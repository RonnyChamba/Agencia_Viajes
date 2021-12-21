import { ajax, createQueryString } from "./ajax.js";
const $d = document;
const $form = $d.forms["form-search"];
const $selectTablas = $form["select-tabla"];
const $selectFiltro = $form["select-filtro"];
const $modal = document.getElementById("modal");

const $formModal = $d.forms["form-update"];

$formModal.addEventListener("submit", function (event) {
  event.preventDefault();
  preActualizar(this, this.dataset["type"]);
});

async function preActualizar(form, tipoTabla) {
  // Datos del formulario  a actualizar
  let datosForm = getDatosForm(form, tipoTabla);

  let queryString = createQueryString(datosForm);

  const { xhr, estado } = await ajax(
    `../php/php-sql-update/sql-${files[tipoTabla]}?${queryString}`
  );

  // Mostrar formulario con los datos a actualizar
  let data = JSON.parse(xhr.responseText);
  // console.log(data);
  let $modalFooter = $modal.querySelector("#modal-footer");
  $modalFooter.textContent = data.mensaje;
  $modalFooter.classList.add("modal-footer--show");

  setTimeout(() => {
    $modalFooter.classList.remove("modal-footer--show");
  }, 5000);
}

$selectTablas.addEventListener("click", () => selectedOption());
$form.addEventListener("submit", function (event) {
  event.preventDefault();
  let index = $selectTablas.selectedIndex;
  if (index != -1) {
    let tablaSelected = $selectTablas.children[index].value;
    let filtro = $form["busqueda"].value;
    buscar(tablaSelected, filtro);
    return;
  }
  alert("Seleccione una tabla");
});

$modal.addEventListener("click", function (event) {
  if (event.target.matches("p#modal-close"))
    this.classList.remove("modal--show");
});
const tablas = {
  EMPLEADOS: "EMPLEADOS",
  // TIPO_VIAJE: "TIPO VIAJES",
  // LICENCIA: "LICENCIAS",
  // DESTINO: "DESTINOS",
  CLIENTES: "CLIENTES",
  // TIPO_TRANSPORTE: "TIPO TRANSPORTE",
  CONDUCTOR: "CONDUCTORES",
  // TRANSPORTE: "TRANSPORTES",
  // COMPRA: "COMPRAS",
  //FACTURA: "FACTURAS",
};

/* Archivos  encargados  mostrar consulta  o actualizar */
const files = {
  EMPLEADOS: "update-empleados.php",
  //TIPO_VIAJE: "list-tipo-viaje.php",
  //LICENCIA: "list-licencias.php",
  //DESTINO: "list-destino.php",
  CLIENTES: "update-clientes.php",
  //TIPO_TRANSPORTE: "list-tipo-transporte.php",
  CONDUCTOR: "update-conductor.php",
  //TRANSPORTE: "list-transporte.php",
  //COMPRA: "list-compra.php",
  //FACTURA: "list-facturas.php",
};
const filtros = {
  CLIENTES: {
    CLIENTES_CED: "CEDULA",
    // CLIENTES_NOM: "NOMBRE",
    // CLIENTES_APE: "APELLIDO",
  },
  EMPLEADOS: {
    EMPLEADOS_CED: "CEDULA",
    // EMPLEADOS_NOM: "NOMBRE",
    // EMPLEADOS_APE: "APELLIDO",
  },
  TIPO_TRANSPORTE: {
    TIPO_TRANSPORTE_NOM: "TIPO",
    TIPO_TRANSPORTE_ASI: "NUMERO ASIENTOS",
  },
  TIPO_VIAJE: {
    TIPO_VIAJE_TIP: "TIPO",
    TIPO_VIAJE_PRE: "PRECIO",
  },
  CONDUCTOR: {
    CONDUCTOR_CED: "CEDULA",
    //CONDUCTOR_NOM: "NOMBRE",
    //CONDUCTOR_APE: "APELLIDO",
    //CONDUCTOR_TEL: "TELEFONO",
  },
  LICENCIA: {
    LICENCIA_TIP: "TIPO",
    LICENCIA_FK_CON: "DNI CONDUCTOR",
  },
  TRANSPORTE: {
    TRANSPORTE_MAT: "MATRICULA",
    TRANSPORTE_COL: "COLOR",
    TRANSPORTE_AG_F: "AÑO FABRICACIÓN",
    TIPO_TRANSPORTE_NOM: "TIPO TRANSPORTE",
    CONDUCTOR_NOM: "NOMBRE CONDUCTOR",
  },
  DESTINO: {
    DESTINO_LUG: "LUGAR",
    DESTINO_CIU: "CIUDAD",
    DESTINO_PAI: "PAIS",
  },
  COMPRA: {
    COMPRA_COD: "CODIGO",
    CLIENTES_APE: "APELLIDO CLIENTE",
    EMPLEADOS_APE: "APELLIDO EMPLEADO",
    DESTINO_LUG: "LUGAR VIAJE",
    TIPO_TRANSPORTE_NOM: "TIPO TRANSPORTE",
  },
  FACTURA: {
    FACTURA_COD: "CODIGO FACTURA",
    COMPRA_COD: "CODIGO COMPRA",
    CLIENTES_APE: "APELLIDO CLIENTE",
  },
};

function setTablas() {
  $selectTablas.appendChild(createOptionFragment(tablas));
  selectedOption();
}

function selectedOption() {
  let index = $selectTablas.selectedIndex;
  if (index != -1) {
    let tablaSelected = $selectTablas.children[index].value;
    setCamposFiltro(tablaSelected);
  }
}

function setCamposFiltro(tabla) {
  if (tablas.hasOwnProperty(tabla)) {
    let nombreFiltros = filtros[tabla];
    $selectFiltro.innerHTML = "";
    $selectFiltro.appendChild(createOptionFragment(nombreFiltros));
    return;
  }
  alert("Tabla no existe");
}
function createOptionFragment(objData) {
  let fragment = $d.createDocumentFragment();
  for (const key in objData) {
    let option = $d.createElement("OPTION");
    option.setAttribute("value", key);
    option.textContent = objData[key];
    fragment.appendChild(option);
  }
  return fragment;
}
setTablas();

async function buscar(tabla, filtro) {
  // Consultar
  let queryString = createQueryString({ filtro, tabla: tabla.toLowerCase() });
  const { xhr, estado } = await ajax(
    `../php/consulta-existe.php?${queryString}`
  );

  // Mostrar formulario con los datos a actualizar
  let data = JSON.parse(xhr.responseText);
  if (data) cargarModalFormUpdate(data, tabla);
  else alert(`El ${tabla} con la cédula ${filtro} no existe`);
}

async function cargarModalFormUpdate(data, tabla) {
  let queryString = createQueryString({ data: JSON.stringify(data) });
  // Peticion haci archivos form update
  const formulario = await ajax(
    `../php/php-view-update/view-${files[tabla]}?${queryString}`
  );

  // Retorna un contenedor con los datos para agregar al form del modal
  let formUpdate = formulario.xhr.responseText;

  // Para indenficar el tipo de objeto
  $formModal.dataset["type"] = tabla;
  $formModal.innerHTML = formUpdate;
  $modal.querySelector(
    "#modal-subtitle"
  ).textContent = `Actualizar  ${tabla.toLowerCase()} `;
  $modal.classList.add("modal--show");
}
function getDatosForm(form, tipoTabla) {
  if (tipoTabla === "EMPLEADOS") return getDatosFormEmpleado(form);
  if (tipoTabla === "CLIENTES") return getDatosFormCliente(form);
  if (tipoTabla === "CONDUCTOR") return getDatosFormConductor(form);
}

function getDatosFormEmpleado(form) {
  let cedula = form.elements["cedula"].value;
  let nombres = form.elements["nombres"].value;
  let apellidos = form.elements["apellidos"].value;
  let direccion = form.elements["direccion"].value;
  let edad = form.elements["edad"].value;
  edad = edad == "" ? "0" : edad;
  let estado = form.elements["estado"].value;
  let telefono = form.elements["telefono"].value;
  let sueldo = form.elements["sueldo"].value;
  sueldo = sueldo == "" ? "0" : sueldo;

  const datos = {
    cedula,
    nombres,
    apellidos,
    direccion,
    edad,
    estado,
    telefono,
    sueldo,
  };

  return datos;
}
function getDatosFormCliente(form) {
  let cedula = form.elements["cedula"].value;
  let nombres = form.elements["nombres"].value;
  let apellidos = form.elements["apellidos"].value;
  let direccion = form.elements["direccion"].value;
  let edad = form.elements["edad"].value;
  edad = edad == "" ? "0" : edad;
  let nacionalidad = form.elements["nacionalidad"].value;
  let estado = form.elements["estado"].value;
  let telefono = form.elements["telefono"].value;
  let estudios = form.elements["estudios"].value;

  const datos = {
    cedula,
    nombres,
    apellidos,
    direccion,
    edad,
    nacionalidad,
    estado,
    telefono,
    estudios,
  };

  return datos;
}
function getDatosFormConductor(form) {
  let cedula = form.elements["cedula"].value;
  let nombres = form.elements["nombres"].value;
  let apellidos = form.elements["apellidos"].value;
  let telefono = form.elements["telefono"].value;
  const datos = {
    cedula,
    nombres,
    apellidos,
    telefono,
  };

  return datos;
}
