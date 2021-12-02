import { ajax, createQueryString } from "./ajax.js";
const $form = document.forms["form-insert-tipo-transporte"];
const $modal = document.getElementById("modal");
$form.addEventListener("submit", function (event) {
  preInsert(event, this);
});
async function preInsert(event, form) {
  event.preventDefault();
  let nombre = form.elements["nombre"].value;
  let queryString = createQueryString({
    filtro: nombre,
    tabla: "tipo-transporte",
  });
  const { xhr, estado } = await ajax(
    `../php/consulta-existe.php?${queryString}`
  );
  let data = JSON.parse(xhr.responseText);
  if (estado) {
    if (data === null) {
      guardar(form);
    } else alertMensaje(`Tipo transporte ${nombre} ya se encuentra registrado`);
  }
}

async function guardar(form) {
  let queryString = createQueryString(obtenerValores(form));
  const retr = await ajax(
    `../php/php-sql-insert/sql-insert-tipo-trp.php?${queryString}`
  );
  const data = JSON.parse(retr.xhr.responseText);
  let objeto = data.objeto;
  createTable(JSON.parse(objeto));
}

function obtenerValores(form) {
  let nombre = form.elements["nombre"].value;
  let asientos = form.elements["asientos"].value;
  asientos = asientos == "" ? "0" : asientos;
  const datos = {
    nombre,
    asientos,
  };

  return datos;
}

function createTable(objeto) {
  let table = document.createElement("TABLE");
  table.classList.add("table");
  table.appendChild(getHeadTable());
  table.appendChild(getBodyTable(objeto));
  $modal.querySelector(".modal-table").innerHTML = "";
  $modal.querySelector(".modal-table").appendChild(table);
  $modal.querySelector(".modal-parrafo").textContent =
    "Tipo transporte guardado correctamente.";
  $modal.classList.add("modal--show");
}
function getHeadTable() {
  let tableHead = document.createElement("THEAD");
  tableHead.classList.add("table-head");
  let row = document.createElement("TR");
  for (const key in getTitleTable()) {
    let celda = document.createElement("TH");
    celda.classList.add("table-celd", "table-celd--th");
    celda.textContent = getTitleTable()[key];
    row.appendChild(celda);
  }
  tableHead.append(row);
  return tableHead;
}

function getBodyTable(objeto) {
  let tableBody = document.createElement("TBODY");
  tableBody.classList.add("table-body");
  let row = document.createElement("TR");
  for (const key in getTitleTable()) {
    let celda = document.createElement("TD");
    celda.classList.add("table-celd", "table-celd--td");
    celda.textContent = objeto[key];
    row.appendChild(celda);
  }
  tableBody.append(row);
  return tableBody;
}

function getTitleTable() {
  const titles = {
    TIPO_TRANSPORTE_COD: "CODIGO",
    TIPO_TRANSPORTE_NOM: "TIPO",
    TIPO_TRANSPORTE_ASI: "ASIENTOS",
  };
  return titles;
}

$modal.addEventListener("click", function (event) {
  if (event.target.matches("#modal button")) {
    this.classList.remove("modal--show");
    reiniciar();
  }
});

function reiniciar() {
  $form.elements["nombre"].value = "";
  $form.elements["asientos"].value = "";
}

function alertMensaje(sms = "Mensaje del sistema") {
  $modal.querySelector(".modal-table").innerHTML = "";
  $modal.querySelector(".modal-parrafo").textContent = sms;
  $modal.classList.add("modal--show");
}
