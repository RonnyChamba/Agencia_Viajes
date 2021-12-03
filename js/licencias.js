import { ajax, createQueryString } from "./ajax.js";
const $form = document.forms["form-insert-licencia"];
const $modal = document.getElementById("modal");

// true: tabla licencias, false: tabla conductores
let bandera = true;
$form.addEventListener("submit", function (event) {
  preInsert(event, this);
});

$form
  .querySelector("#add-conductor")
  .addEventListener("click", function (event) {
    event.preventDefault();
    bandera = false;
    listarConductores();
  });

function preInsert(event, form) {
  event.preventDefault();
  bandera = true;
  isExist(form);
}

async function isExist(form) {
  let nombre = form.elements["nombre"].value;
  let cedulaConductor = form.elements["cedula-conductor"].value;

  let queryString = createQueryString({
    filtro: cedulaConductor,
    tabla: "licencia",
    licencia: nombre,
  });
  const { xhr, estado } = await ajax(
    `../php/consulta-existe.php?${queryString}`
  );
  let data = JSON.parse(xhr.responseText);
  console.log(data);
  if (estado) {
    if (data === null) guardar(form);
    else
      alertMensaje(
        `${data.CONDUCTOR_NOM} ${data.CONDUCTOR_APE} ya registra licencia tipo ${data.LICENCIA_TIP}, ingrese un diferente.`
      );
  }
}

async function guardar(form) {
  let queryString = createQueryString(obtenerValores(form));
  const retr = await ajax(
    `../php/php-sql-insert/sql-insert-licencias.php?${queryString}`
  );
  // console.log(retr);
  const data = JSON.parse(retr.xhr.responseText);
  let objeto = data.objeto;
  createTable(JSON.parse(objeto));
}

function obtenerValores(form) {
  let nombre = form.elements["nombre"].value;
  // El input donde se obtiene este valor es type hidden
  let conductor = form.elements["cedula-conductor"].value;
  let fechaExpedicion = form.elements["fechaExpedicion"].value;
  let fechaExpiracion = form.elements["fechaExpiracion"].value;
  const datos = {
    nombre,
    conductor,
    fechaExpedicion,
    fechaExpiracion,
  };
  return datos;
}

async function listarConductores() {
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

function createTable(objeto) {
  let table = document.createElement("TABLE");
  table.classList.add("table");
  table.appendChild(getHeadTable());
  table.appendChild(getBodyTable(objeto));
  $modal.querySelector(".modal-table").innerHTML = "";
  $modal.querySelector(".modal-table").appendChild(table);
  $modal.querySelector(".modal-parrafo").textContent = bandera
    ? "Licencia guardada correctamente"
    : "Conductores registrados";
  $modal.classList.add("modal--show");
}
function getHeadTable() {
  let tableHead = document.createElement("THEAD");
  tableHead.classList.add("table-head");
  let row = document.createElement("TR");
  let dataHead = getTitleTable();
  for (const key in dataHead) row.appendChild(createCelda("th", dataHead[key]));
  // Tabla conductores agrego una celda mas
  if (!bandera) row.appendChild(createCelda("th", ""));

  tableHead.append(row);
  return tableHead;
}
function getBodyTable(objeto) {
  let tableBody = document.createElement("TBODY");
  tableBody.classList.add("table-body");
  let fragment = bandera
    ? getBodyTableLicencias(objeto)
    : getBodyTableConductores(objeto);
  tableBody.append(fragment);
  return tableBody;
}

function getBodyTableLicencias(objeto) {
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
    celdLink.innerHTML = `<button class ='btn' id='btn-select' data-cedula = ${item.CONDUCTOR_CED} >Seleccionar</button>`;
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
  return bandera ? getTitleTableLicencia() : getTitleTableConductores();
}

function getTitleTableLicencia() {
  const titles = {
    LICENCIA_COD: "CODIGO",
    LICENCIA_TIP: "TIPO",
    LICENCIA_FE_I: "FECHA EXPEDICIÓN",
    LICENCIA_FE_F: "FECHA EXPIRACIÓN",
    LICENCIA_FK_CON: "CONDUCTOR",
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
    if (event.target.id === "btn-select") setDatosConductor(event.target);
    this.classList.remove("modal--show");
    reiniciar();
  }
});

function reiniciar() {
  if (bandera) {
    $form.elements["nombre"].value = "";
    $form.elements["cedula-conductor"].value = "";
    $form.elements["nombre-conductor"].value = "";
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
