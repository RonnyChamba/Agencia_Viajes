import { ajax, createQueryString } from "./ajax.js";
const $form = document.forms["form-insert-destino"];
const $modal = document.getElementById("modal");

// tabla destino or  tabla tipo-viaje
let bandera = "destino";
$form.addEventListener("submit", function (event) {
  preInsert(event, this);
});

$form
  .querySelector("#add-tipo-viaje")
  .addEventListener("click", function (event) {
    event.preventDefault();
    bandera = "tipoViaje";
    listarTipoViaje();
  });

function preInsert(event, form) {
  event.preventDefault();
  bandera = "destino";
  isExist(form);
}

async function isExist(form) {
  let lugar = form.elements["lugar"].value;
  let ciudad = form.elements["ciudad"].value;
  let tipoViaje = form.elements["codigo-tipo-viaje"].value;

  let queryString = createQueryString({
    filtro: lugar,
    tabla: "destino",
    ciudad,
    tipoViaje,
  });
  const { xhr, estado } = await ajax(
    `../php/consulta-existe.php?${queryString}`
  );
  let data = JSON.parse(xhr.responseText);
  // console.log(data);
  if (estado) {
    if (data === null) guardar(form);
    else {
      bandera = "destino";
      setLinkInsertarText();
      alertMensaje(
        `Destino a ${data.DESTINO_LUG}-${data.DESTINO_CIU}-${data.DESTINO_FK_TI_V} ya se encuentra registrado.`
      );
    }
  }
}

async function guardar(form) {
  // Cambia el link y textContent
  setLinkInsertarText();
  let queryString = createQueryString(obtenerValores(form));
  const retr = await ajax(
    `../php/php-sql-insert/sql-insert-destino.php?${queryString}`
  );
  // console.log(retr);
  const data = JSON.parse(retr.xhr.responseText);
  let objeto = data.objeto;
  createTable(JSON.parse(objeto));
}

function obtenerValores(form) {
  let lugar = form.elements["lugar"].value;
  let direccion = form.elements["direccion"].value;
  let ciudad = form.elements["ciudad"].value;
  let pais = form.elements["pais"].value;
  // El input donde se obtiene este valor es type hidden
  let tipoViaje = form.elements["codigo-tipo-viaje"].value;

  const datos = {
    lugar,
    direccion,
    ciudad,
    pais,
    tipoViaje,
  };
  return datos;
}

async function listarTipoViaje() {
  // Cambia el link y textContent
  setLinkInsertarText();
  let queryString = createQueryString({
    tabla: "TIPO_VIAJE",
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

  let textDescripcion =
    bandera === "destino"
      ? "Destino guardado correctamente"
      : "Tipos de viajes registrados";

  $modal.querySelector(".modal-parrafo").textContent = textDescripcion;
  $modal.classList.add("modal--show");
}
function getHeadTable() {
  let tableHead = document.createElement("THEAD");
  tableHead.classList.add("table-head");
  let row = document.createElement("TR");
  let dataHead = getTitleTable();
  for (const key in dataHead) row.appendChild(createCelda("th", dataHead[key]));
  // Tabla tipoViaje
  if (bandera === "tipoViaje") row.appendChild(createCelda("th", ""));

  tableHead.append(row);
  return tableHead;
}
function getBodyTable(objeto) {
  let tableBody = document.createElement("TBODY");
  tableBody.classList.add("table-body");
  let fragment = document.createDocumentFragment();

  if (bandera === "destino") fragment = getBodyTableDestino(objeto);
  if (bandera === "tipoViaje") fragment = getBodyTableTipoViaje(objeto);
  tableBody.append(fragment);
  return tableBody;
}

function getBodyTableDestino(objeto) {
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

function getBodyTableTipoViaje(objeto) {
  let fragment = document.createDocumentFragment();
  objeto.forEach((item) => {
    let row = document.createElement("TR");
    for (const key in getTitleTable()) {
      row.appendChild(createCelda("td", item[key]));
    }

    let celdLink = createCelda("td", "");
    celdLink.innerHTML = `<button class ='btn' id='btn-select-tipo-viaje' data-codigo = ${item.TIPO_VIAJE_COD} >Seleccionar</button>`;
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
  if (bandera == "destino") return getTitleTableDestinos();
  if (bandera == "tipoViaje") return getTitleTableTipoViajes();
}

function getTitleTableTipoViajes() {
  const titles = {
    TIPO_VIAJE_COD: "CODIGO",
    TIPO_VIAJE_TIP: "TIPO",
    TIPO_VIAJE_DES: "DESCRIPCIÓN",
    TIPO_VIAJE_PRE: "PRECIO",
  };
  return titles;
}
function getTitleTableDestinos() {
  const titles = {
    DESTINO_COD: "CODIGO",
    DESTINO_LUG: "LUGAR",
    DESTINO_DIR: "DIRECCION",
    DESTINO_CIU: "CIUDAD",
    DESTINO_PAI: "PAIS",
    DESTINO_FK_TI_V: "TIPO",
  };
  return titles;
}

$modal.addEventListener("click", function (event) {
  if (event.target.matches("#modal button")) {
    // Llenar datos del tipo-viaje antes de insertar un nuevo destino
    if (event.target.id === "btn-select-tipo-viaje")
      setDatosTipoViaje(event.target);
    this.classList.remove("modal--show");
    reiniciar();
  }
});

function reiniciar() {
  if (bandera === "destino") {
    $form.elements["lugar"].value = "";
    $form.elements["direccion"].value = "";
    $form.elements["ciudad"].value = "";

    $form.elements["pais"].value = "";
    $form.elements["codigo-tipo-viaje"].value = "";
    $form.elements["tipo-viaje"].value = "";
  }
}

function alertMensaje(sms = "Mensaje del sistema") {
  $modal.querySelector(".modal-table").innerHTML = "";
  $modal.querySelector(".modal-parrafo").textContent = sms;
  $modal.classList.add("modal--show");
}

function setDatosTipoViaje(boton) {
  let codigo = boton.dataset["codigo"];
  $form.elements["codigo-tipo-viaje"].value = codigo;

  let rowBoton = boton.parentElement.parentElement;
  let rowCeldas = [...rowBoton.cells];
  $form.elements["tipo-viaje"].value = `${rowCeldas[1].textContent}`;
}

function setLinkInsertarText() {
  let fileForm = "";
  let textContent = "";
  if (bandera === "destino") {
    fileForm = "../php/list-destino.php";
    textContent = "Ver Destinos";
  } else if (bandera === "tipoViaje") {
    fileForm = "../view-insert/insert-tipo-viajes.html";
    textContent = "Nuevo Tipo Viaje";
  }

  $modal.querySelector("#modal-link").setAttribute("href", fileForm);
  $modal.querySelector("#modal-link").textContent = textContent;
}
