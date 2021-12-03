import { ajax, createQueryString } from "./ajax.js";
const $form = document.forms["form-insert-transporte"];
const $modal = document.getElementById("modal");

// tabla transporte or  tabla conductores or tabla tipo-transporte
let bandera = true;
$form.addEventListener("submit", function (event) {
  preInsert(event, this);
});

$form
  .querySelector("#add-conductor")
  .addEventListener("click", function (event) {
    event.preventDefault();
    bandera = "conductor";
    listarConductores();
  });
$form
  .querySelector("#add-tipo-transporte")
  .addEventListener("click", function (event) {
    event.preventDefault();
    bandera = "tipoTransporte";
    listarTipoTransporte();
  });

function preInsert(event, form) {
  event.preventDefault();
  bandera = "transporte";
  isExist(form);
}

async function isExist(form) {
  let matricula = form.elements["matricula"].value;
  let queryString = createQueryString({
    filtro: matricula,
    tabla: "transporte",
  });
  const { xhr, estado } = await ajax(
    `../php/consulta-existe.php?${queryString}`
  );
  let data = JSON.parse(xhr.responseText);
  // console.log(data);
  if (estado) {
    if (data === null) guardar(form);
    else {
      bandera = "transporte";
      setLinkInsertarText();
      alertMensaje(
        `Matricula ${data.TRANSPORTE_MAT}  ya se encuentra registrada.`
      );
    }
  }
}

async function guardar(form) {
  // Cambia el link y textContent
  setLinkInsertarText();
  let queryString = createQueryString(obtenerValores(form));
  const retr = await ajax(
    `../php/php-sql-insert/sql-insert-transporte.php?${queryString}`
  );
  // console.log(retr);
  const data = JSON.parse(retr.xhr.responseText);
  let objeto = data.objeto;
  createTable(JSON.parse(objeto));
}

function obtenerValores(form) {
  let matricula = form.elements["matricula"].value;
  let agnioFabricacion = form.elements["agnio-fabricacion"].value;
  let color = form.elements["color"].value;

  // El input donde se obtiene este valor es type hidden
  let conductor = form.elements["cedula-conductor"].value;
  // El input donde se obtiene este valor es type hidden
  let tipoTransporte = form.elements["codigo-tipo-transporte"].value;

  const datos = {
    matricula,
    agnioFabricacion,
    color,
    conductor,
    tipoTransporte,
  };
  return datos;
}

async function listarConductores() {
  // Cambia el link y textContent
  setLinkInsertarText();

  let queryString = createQueryString({
    tabla: "CONDUCTOR",
  });
  const { xhr, estado } = await ajax(
    `../php/consulta-generales.php?${queryString}`
  );
  // Array de objetos
  const conductores = JSON.parse(xhr.responseText);
  createTable(conductores);
}

async function listarTipoTransporte() {
  // Cambia el link y textContent
  setLinkInsertarText();
  let queryString = createQueryString({
    tabla: "TIPO_TRANSPORTE",
  });
  const { xhr, estado } = await ajax(
    `../php/consulta-generales.php?${queryString}`
  );
  // Array de objetos
  const tipoTransporte = JSON.parse(xhr.responseText);
  createTable(tipoTransporte);
}

function createTable(objeto) {
  let table = document.createElement("TABLE");
  table.classList.add("table");
  table.appendChild(getHeadTable());
  table.appendChild(getBodyTable(objeto));
  $modal.querySelector(".modal-table").innerHTML = "";
  $modal.querySelector(".modal-table").appendChild(table);

  let textDescripcion = "";
  if (bandera === "conductor") textDescripcion = "Conductores registrados";
  if (bandera === "transporte")
    textDescripcion = "Transporte guardado correctamente";
  if (bandera === "tipoTransporte")
    textDescripcion = "Tipos de transporte registrados";

  $modal.querySelector(".modal-parrafo").textContent = textDescripcion;
  $modal.classList.add("modal--show");
}
function getHeadTable() {
  let tableHead = document.createElement("THEAD");
  tableHead.classList.add("table-head");
  let row = document.createElement("TR");
  let dataHead = getTitleTable();
  for (const key in dataHead) row.appendChild(createCelda("th", dataHead[key]));
  // Tabla conductor  o tabla tipoTransporte agrego una celda mas
  if (bandera === "conductor" || bandera === "tipoTransporte")
    row.appendChild(createCelda("th", ""));

  tableHead.append(row);
  return tableHead;
}
function getBodyTable(objeto) {
  let tableBody = document.createElement("TBODY");
  tableBody.classList.add("table-body");
  let fragment = document.createDocumentFragment();

  if (bandera === "conductor") fragment = getBodyTableConductores(objeto);
  if (bandera === "transporte") fragment = getBodyTableTransporte(objeto);
  if (bandera === "tipoTransporte")
    fragment = getBodyTableTipoTransporte(objeto);
  tableBody.append(fragment);
  return tableBody;
}

function getBodyTableTransporte(objeto) {
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

function getBodyTableConductores(objeto) {
  let fragment = document.createDocumentFragment();
  objeto.forEach((item) => {
    let row = document.createElement("TR");
    for (const key in getTitleTable()) {
      row.appendChild(createCelda("td", item[key]));
    }

    let celdLink = createCelda("td", "");
    celdLink.innerHTML = `<button class ='btn' id='btn-select-conductor' data-cedula = ${item.CONDUCTOR_CED} >Seleccionar</button>`;
    row.appendChild(celdLink);
    fragment.appendChild(row);
  });
  return fragment;
}

function getBodyTableTipoTransporte(objeto) {
  // console.log(objeto);
  let fragment = document.createDocumentFragment();
  objeto.forEach((item) => {
    let row = document.createElement("TR");
    for (const key in getTitleTable()) {
      row.appendChild(createCelda("td", item[key]));
    }

    let celdLink = createCelda("td", "");
    celdLink.innerHTML = `<button class ='btn' id='btn-select-tipo' data-codigo = ${item.TIPO_TRANSPORTE_COD} >Seleccionar</button>`;
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
  if (bandera == "conductor") return getTitleTableConductores();
  if (bandera == "tipoTransporte") return getTitleTableTipoTransporte();
  if (bandera == "transporte") return getTitleTableTransporte();
}

function getTitleTableTipoTransporte() {
  const titles = {
    TIPO_TRANSPORTE_COD: "CODIGO",
    TIPO_TRANSPORTE_NOM: "TIPO",
    TIPO_TRANSPORTE_ASI: "NÚMERO DE ASIENTOS",
  };
  return titles;
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

function getTitleTableConductores() {
  const titles = {
    CONDUCTOR_CED: "CEDULA",
    CONDUCTOR_NOM: "NOMBRES",
    CONDUCTOR_APE: "APELLIDOS",
    CONDUCTOR_TEL: "TELEFONO",
  };
  return titles;
}

$modal.addEventListener("click", function (event) {
  if (event.target.matches("#modal button")) {
    // Llenar datos del conductor antes de insertar una licencia
    if (event.target.id === "btn-select-conductor")
      setDatosConductor(event.target);
    if (event.target.id === "btn-select-tipo")
      setDatosTipoTransporte(event.target);
    this.classList.remove("modal--show");
    reiniciar();
  }
});

function reiniciar() {
  if (bandera === "transporte") {
    $form.elements["matricula"].value = "";
    $form.elements["agnio-fabricacion"].value = "";
    $form.elements["color"].value = "";

    $form.elements["cedula-conductor"].value = "";
    $form.elements["nombre-conductor"].value = "";
    $form.elements["codigo-tipo-transporte"].value = "";
    $form.elements["tipo-transporte"].value = "";
  }
}

function alertMensaje(sms = "Mensaje del sistema") {
  $modal.querySelector(".modal-table").innerHTML = "";
  $modal.querySelector(".modal-parrafo").textContent = sms;
  $modal.classList.add("modal--show");
}

function setDatosConductor(boton) {
  let cedula = boton.dataset["cedula"];
  $form.elements["cedula-conductor"].value = cedula;

  let rowBoton = boton.parentElement.parentElement;
  let rowCeldas = [...rowBoton.cells];
  $form.elements[
    "nombre-conductor"
  ].value = `${rowCeldas[1].textContent} ${rowCeldas[2].textContent}`;
}

function setDatosTipoTransporte(boton) {
  let cedula = boton.dataset["codigo"];
  $form.elements["codigo-tipo-transporte"].value = cedula;

  let rowBoton = boton.parentElement.parentElement;
  let rowCeldas = [...rowBoton.cells];
  $form.elements["tipo-transporte"].value = `${rowCeldas[1].textContent}`;
}

function setLinkInsertarText() {
  let fileForm = "";
  let textContent = "";
  if (bandera === "transporte") {
    fileForm = "../php/list-transporte.php";
    textContent = "Ver Transportes";
  } else if (bandera === "tipoTransporte") {
    fileForm = "../view-insert/insert-tipo-transporte.html";
    textContent = "Nuevo Tipo Transporte";
  } else if (bandera === "conductor") {
    fileForm = "../view-insert/insert-conductor.html";
    textContent = "Nuevo Conductor";
  }

  $modal.querySelector("#modal-link").setAttribute("href", fileForm);
  $modal.querySelector("#modal-link").textContent = textContent;
}
