import { ajax, createQueryString } from "./ajax.js";
const $form = document.forms["form-insert-compra"];
const $modal = document.getElementById("modal");

// tabla compra  or  tabla clientre table empleados or tabla transporte or tabla destino
let bandera = true;
$form.addEventListener("submit", function (event) {
  event.preventDefault();
  guardar(this);
});

$form.querySelector("#add-cliente").addEventListener("click", function (event) {
  event.preventDefault();
  bandera = "cliente";
  listarClientes();
});
$form
  .querySelector("#add-transporte")
  .addEventListener("click", function (event) {
    event.preventDefault();
    bandera = "transporte";
    listarTransportes();
  });

$form.querySelector("#add-destino").addEventListener("click", function (event) {
  event.preventDefault();
  bandera = "destino";
  listarDestinos();
});
$form
  .querySelector("#add-empleado")
  .addEventListener("click", function (event) {
    event.preventDefault();
    bandera = "empleado";
    listarEmpleados();
  });

$form.elements["boletos"].addEventListener("change", () => calcularPrecio());

$form.elements["boletos"].addEventListener("keyup", () => calcularPrecio());

async function guardar(form) {
  // Cambia el link y textContent
  bandera = "compra";
  setLinkInsertarText();
  let queryString = createQueryString(obtenerValores(form));
  const retr = await ajax(
    `../php/php-sql-insert/sql-insert-compra.php?${queryString}`
  );
  const data = JSON.parse(retr.xhr.responseText);
  if (retr.estado && data.estado) {
    let codigoCompra = JSON.parse(data.objeto).COMPRA_COD;
    guardarFactura(codigoCompra, form);

    // createTable(JSON.parse(objeto));
  } else {
    console.log("Ocurrio un error");
  }
}

function obtenerValores(form) {
  let boletos = form.elements["boletos"].value;
  // El input donde se obtiene estos valores son  type hidden
  let cliente = form.elements["cedula-cliente"].value;
  let destino = form.elements["codigo-destino"].value;
  let transporte = form.elements["codigo-transporte"].value;
  let empleado = form.elements["cedula-empleado"].value;

  const datos = {
    boletos,
    cliente,
    destino,
    transporte,
    empleado,
  };
  // console.log("datos obtenidos", datos);
  return datos;
}
function obtenerValoresFactura(codCompra, form) {
  let observacion = form.elements["observacion"].value;
  let subtotal = form.elements["subtotal"].value;
  let total = form.elements["total"].value;

  const datos = {
    observacion,
    codCompra,
    subtotal,
    total,
  };
  return datos;
}

async function listarClientes() {
  // Cambia el link y textContent
  setLinkInsertarText();

  let queryString = createQueryString({
    tabla: "CLIENTES",
  });
  const { xhr, estado } = await ajax(
    `../php/consulta-generales.php?${queryString}`
  );
  // Array de objetos
  const clientes = JSON.parse(xhr.responseText);
  createTable(clientes);
}

async function listarTransportes() {
  // Cambia el link y textContent
  setLinkInsertarText();
  let queryString = createQueryString({
    tabla: "TRANSPORTE",
  });
  const { xhr, estado } = await ajax(
    `../php/consulta-generales.php?${queryString}`
  );
  // Array de objetos
  const transporte = JSON.parse(xhr.responseText);
  createTable(transporte);
}
async function listarDestinos() {
  // Cambia el link y textContent
  setLinkInsertarText();
  // console.log(bandera);
  let queryString = createQueryString({
    tabla: "DESTINO",
  });
  const { xhr, estado } = await ajax(
    `../php/consulta-generales.php?${queryString}`
  );
  // Array de objetos

  const destino = JSON.parse(xhr.responseText);
  createTable(destino);
}

async function listarEmpleados() {
  // Cambia el link y textContent
  setLinkInsertarText();
  let queryString = createQueryString({
    tabla: "EMPLEADOS",
  });
  const { xhr, estado } = await ajax(
    `../php/consulta-generales.php?${queryString}`
  );
  // Array de objetos
  const empleados = JSON.parse(xhr.responseText);
  createTable(empleados);
}

function createTable(objeto) {
  let table = document.createElement("TABLE");
  table.classList.add("table");
  table.appendChild(getHeadTable());
  table.appendChild(getBodyTable(objeto));
  $modal.querySelector(".modal-table").innerHTML = "";
  $modal.querySelector(".modal-table").appendChild(table);

  let textDescripcion = "";
  if (bandera === "compra") textDescripcion = "Compra guardada correctamente";
  if (bandera === "cliente") textDescripcion = "Clientes registrados";
  if (bandera === "transporte") textDescripcion = "Transporte registrados";
  if (bandera === "empleado") textDescripcion = "Empleados registrados";
  if (bandera === "destino") textDescripcion = "Destinos registrados";

  $modal.querySelector(".modal-parrafo").textContent = textDescripcion;
  $modal.classList.add("modal--show");
}
function getHeadTable() {
  let tableHead = document.createElement("THEAD");
  tableHead.classList.add("table-head");
  let row = document.createElement("TR");
  let dataHead = getTitleTable();
  for (const key in dataHead) row.appendChild(createCelda("th", dataHead[key]));
  // Tabla cliente  o tabla transporte o tabla destino o tabla empleado agrego una celda mas
  if (
    bandera === "cliente" ||
    bandera === "transporte" ||
    bandera === "empleado" ||
    bandera === "destino"
  )
    row.appendChild(createCelda("th", ""));

  tableHead.append(row);
  return tableHead;
}
function getBodyTable(objeto) {
  let tableBody = document.createElement("TBODY");
  tableBody.classList.add("table-body");
  let fragment = document.createDocumentFragment();

  if (bandera === "compra") fragment = getBodyTableCompra(objeto);
  if (bandera === "cliente") fragment = getBodyTableClientes(objeto);
  if (bandera === "transporte") fragment = getBodyTableTransporte(objeto);
  if (bandera === "destino") fragment = getBodyTableDestino(objeto);
  if (bandera === "empleado") fragment = getBodyTableEmpledos(objeto);
  tableBody.append(fragment);
  return tableBody;
}

function getBodyTableCompra(objeto) {
  let fragment = document.createDocumentFragment();
  let row = document.createElement("TR");
  let dataHead = getTitleTable();
  for (const key in dataHead) {
    row.appendChild(createCelda("td", objeto[key]));
  }

  // No era necesario guardar en un fragment
  fragment.appendChild(row);
  return fragment;
}

function getBodyTableClientes(objeto) {
  let fragment = document.createDocumentFragment();
  objeto.forEach((item) => {
    let row = document.createElement("TR");
    for (const key in getTitleTable()) {
      row.appendChild(createCelda("td", item[key]));
    }

    let celdLink = createCelda("td", "");
    celdLink.innerHTML = `<button class ='btn' id='btn-select-cliente' data-codigo = ${item.CLIENTES_CED} >Seleccionar</button>`;
    row.appendChild(celdLink);
    fragment.appendChild(row);
  });
  return fragment;
}

function getBodyTableTransporte(objeto) {
  // console.log(objeto);
  let fragment = document.createDocumentFragment();
  objeto.forEach((item) => {
    let row = document.createElement("TR");
    for (const key in getTitleTable()) {
      row.appendChild(createCelda("td", item[key]));
    }

    let celdLink = createCelda("td", "");
    celdLink.innerHTML = `<button class ='btn' id='btn-select-transporte' data-codigo = ${item.TRANSPORTE_COD} >Seleccionar</button>`;
    row.appendChild(celdLink);
    fragment.appendChild(row);
  });
  return fragment;
}

function getBodyTableDestino(objeto) {
  // console.log(objeto);
  let fragment = document.createDocumentFragment();
  objeto.forEach((item) => {
    let row = document.createElement("TR");
    for (const key in getTitleTable()) {
      row.appendChild(createCelda("td", item[key]));
    }

    let celdLink = createCelda("td", "");
    celdLink.innerHTML = `<button class ='btn' id='btn-select-destino' data-codigo = ${item.DESTINO_COD} >Seleccionar</button>`;
    row.appendChild(celdLink);
    fragment.appendChild(row);
  });
  return fragment;
}

function getBodyTableEmpledos(objeto) {
  // console.log(objeto);
  let fragment = document.createDocumentFragment();
  objeto.forEach((item) => {
    let row = document.createElement("TR");
    for (const key in getTitleTable()) {
      row.appendChild(createCelda("td", item[key]));
    }

    let celdLink = createCelda("td", "");
    celdLink.innerHTML = `<button class ='btn' id='btn-select-empleado' data-codigo = ${item.EMPLEADOS_CED} >Seleccionar</button>`;
    row.appendChild(celdLink);
    fragment.appendChild(row);
  });
  return fragment;
}

function createCelda(tipoCelda = "td", dato = "") {
  let celda = document.createElement(tipoCelda.toUpperCase());
  celda.classList.add("table-celd", `table-celd--${tipoCelda}`);
  celda.textContent = dato;
  return celda;
}
function getTitleTable() {
  if (bandera == "compra") return getTitleTableCompra();
  if (bandera == "cliente") return getTitleTableCliente();
  if (bandera == "destino") return getTitleTableDestino();
  if (bandera == "transporte") return getTitleTableTransporte();
  if (bandera == "empleado") return getTitleTableEmpleado();
}

function getTitleTableDestino() {
  const titles = {
    DESTINO_COD: "CODIGO",
    DESTINO_LUG: "LUGAR",
    DESTINO_DIR: "DIRECCION",
    DESTINO_CIU: "CIUDAD",
    DESTINO_PAI: "PAIS",
    DESTINO_FK_TI_V: "TIPO",
    TIPO_VIAJE_PRE: "PRECIO",
  };
  return titles;
}

function getTitleTableCompra() {
  const title = {
    COMPRA_COD: "CODIGO",
    COMPRA_FEC: "FECHA",
    COMPRA_NU_B: "BOLETOS",
    COMPRA_FK_CLI: "CLIENTE",
    COMPRA_FK_DES: "DESTINO",
    COMPRA_FK_TRA: "TRANSPORTE",
    COMPRA_FK_EMP: "EMPLEADO",
  };
  return title;
}

function getTitleTableTransporte() {
  const titles = {
    TRANSPORTE_COD: "CODIGO",
    TRANSPORTE_MAT: "MATRICULA",
    TRANSPORTE_COL: "COLOR",
    TRANSPORTE_AG_F: "AÑO FABRICACIÓN",
    TRANSPORTE_FK_TI_T: "TIPO",
    TRANSPORTE_FK_CON: "CONDUCTOR",
  };
  return titles;
}

function getTitleTableCliente() {
  const titles = {
    CLIENTES_CED: "CEDULA",
    CLIENTES_NOM: "NOMBRES",
    CLIENTES_APE: "APELLIDOS",
    CLIENTES_DIR: "DIRECCIÓN",
    CLIENTES_EDA: "EDAD",
    CLIENTES_NAC: "NACIMIENTO",
    CLIENTES_ES_C: "ESTADO",
    CLIENTES_TEL: "TELEFONO",
    CLIENTES_ES_R: "ESTUDIOS",
  };
  return titles;
}

function getTitleTableEmpleado() {
  const titles = {
    EMPLEADOS_CED: "CEDULA",
    EMPLEADOS_NOM: "NOMBRES",
    EMPLEADOS_APE: "APELLIDOS",
    EMPLEADOS_DIR: "DIRECCIÓN",
    EMPLEADOS_EDA: "EDAD",
    EMPLEADOS_ES_C: "ESTADO",
    EMPLEADOS_TEL: "TELEFONO",
    EMPLEADOS_SAL: "SUELDO",
  };
  return titles;
}

$modal.addEventListener("click", function (event) {
  if (event.target.matches("#modal button")) {
    // console.log(event);
    if (event.target.id === "btn-select-cliente") setDatosCliente(event.target);
    if (event.target.id === "btn-select-transporte")
      setDatosTransporte(event.target);
    if (event.target.id === "btn-select-destino") setDatosDestino(event.target);
    if (event.target.id === "btn-select-empleado")
      setDatosEmpleado(event.target);
    this.classList.remove("modal--show");
    reiniciar();
  }
});

function reiniciar() {
  if (bandera === "compra") {
    $form.elements["boleto"].value = "1";
    $form.elements["cedula-cliente"].value = "";
    $form.elements["nombre-cliente"].value = "";

    $form.elements["codigo-destino"].value = "";
    $form.elements["tipo-destino"].value = "";

    $form.elements["codigo-transporte"].value = "";
    $form.elements["tipo-transporte"].value = "";

    $form.elements["cedula-empleado"].value = "";
    $form.elements["nombre-empleado"].value = "";

    $form.elements["observacion"].value = "";

    $form.elements["precio"].value = "0.00";
    $form.elements["subtotal"].value = "0.00";
    $form.elements["iva"].value = "0.00";
    $form.elements["total"].value = "0.00";
  }
}

function alertMensaje(sms = "Mensaje del sistema") {
  $modal.querySelector(".modal-table").innerHTML = "";
  $modal.querySelector(".modal-parrafo").textContent = sms;
  $modal.classList.add("modal--show");
}

function setDatosCliente(boton) {
  let cedula = boton.dataset["codigo"];
  $form.elements["cedula-cliente"].value = cedula;

  let rowBoton = boton.parentElement.parentElement;
  let rowCeldas = [...rowBoton.cells];
  $form.elements[
    "nombre-cliente"
  ].value = `${rowCeldas[1].textContent} ${rowCeldas[2].textContent}`;
}

function setDatosTransporte(boton) {
  let cedula = boton.dataset["codigo"];
  $form.elements["codigo-transporte"].value = cedula;

  let rowBoton = boton.parentElement.parentElement;
  let rowCeldas = [...rowBoton.cells];
  $form.elements[
    "tipo-transporte"
  ].value = `${rowCeldas[4].textContent} - ${rowCeldas[2].textContent}`;
}
function setDatosDestino(boton) {
  let cedula = boton.dataset["codigo"];
  $form.elements["codigo-destino"].value = cedula;

  let rowBoton = boton.parentElement.parentElement;
  let rowCeldas = [...rowBoton.cells];
  $form.elements["tipo-destino"].value = `${rowCeldas[1].textContent}`;

  // Ubicar el precio del destino seleccionado en el input
  let precio = boton.parentElement.parentElement.cells[6].textContent;
  $form.elements["precio"].value = precio;
  calcularPrecio();
}
function setDatosEmpleado(boton) {
  let cedula = boton.dataset["codigo"];
  $form.elements["cedula-empleado"].value = cedula;

  let rowBoton = boton.parentElement.parentElement;
  let rowCeldas = [...rowBoton.cells];
  $form.elements[
    "nombre-empleado"
  ].value = `${rowCeldas[1].textContent} ${rowCeldas[2].textContent} `;
}

function calcularPrecio() {
  let precio = parseFloat($form.elements["precio"].value);
  let boletos = $form.elements["boletos"].value;
  let subtotal = precio * boletos;
  let iva = (subtotal * 12) / 100;
  let total = subtotal + iva;
  $form.elements["precio"].value = precio;
  $form.elements["subtotal"].value = subtotal;
  $form.elements["iva"].value = iva;
  $form.elements["total"].value = total;
}
function setLinkInsertarText() {
  let fileForm = "";
  let textContent = "";
  if (bandera === "compra") {
    fileForm = "../php/list-compra.php";
    textContent = "Ver Compras";
  } else if (bandera === "transporte") {
    fileForm = "../view-insert/insert-transporte.html";
    textContent = "Nuevo Transporte";
  } else if (bandera === "destino") {
    fileForm = "../view-insert/insert-destino.html";
    textContent = "Nuevo Destino";
  } else if (bandera === "cliente") {
    fileForm = "../view-insert/insert-clientes.html";
    textContent = "Nuevo Cliente";
  } else if (bandera === "empleado") {
    fileForm = "../view-insert/insert-empleado.html";
    textContent = "Nuevo Empleado";
  }

  $modal.querySelector("#modal-link").setAttribute("href", fileForm);
  $modal.querySelector("#modal-link").textContent = textContent;
}

async function guardarFactura(codCompra, form) {
  let queryString = createQueryString(obtenerValoresFactura(form, codCompra));
  const retr = await ajax(
    `../php/php-sql-insert/sql-insert-factura.php?${queryString}`
  );
}
