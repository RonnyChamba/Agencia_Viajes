import { ajax, createQueryString } from "./ajax.js";
const $form = document.forms["form-insert-conductor"];
const $modal = document.getElementById("modal");
$form.addEventListener("submit", function (event) {
  preInsert(event, this);
});
async function preInsert(event, form) {
  event.preventDefault();
  let cedula = form.elements["cedula"].value;
  let queryString = createQueryString({
    filtro: cedula,
    tabla: "conductor",
  });
  const { xhr, estado } = await ajax(
    `../php/consulta-existe.php?${queryString}`
  );
  let data = JSON.parse(xhr.responseText);
  if (estado) {
    if (data === null) {
      guardar(form);
    } else
      alertMensaje(
        `Conductor con la cédula ${cedula} ya se encuentra registrado`
      );
  }
}

async function guardar(form) {
  let queryString = createQueryString(obtenerValores(form));
  const retr = await ajax(
    `../php/php-sql-insert/sql-insert-conductor.php?${queryString}`
  );
  const data = JSON.parse(retr.xhr.responseText);
  let persona = data.persona;
  createTable(JSON.parse(persona));
}

function obtenerValores(form) {
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

function createTable(conductor) {
  let table = document.createElement("TABLE");
  table.classList.add("table");
  table.appendChild(getHeadTable());
  table.appendChild(getBodyTable(conductor));
  $modal.querySelector(".modal-table").innerHTML = "";
  $modal.querySelector(".modal-table").appendChild(table);
  $modal.querySelector(".modal-parrafo").textContent =
    "Conductor guardado correctamente.";
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

function getBodyTable(conductor) {
  let tableBody = document.createElement("TBODY");
  tableBody.classList.add("table-body");
  let row = document.createElement("TR");
  for (const key in getTitleTable()) {
    let celda = document.createElement("TD");
    celda.classList.add("table-celd", "table-celd--td");
    celda.textContent = conductor[key];
    row.appendChild(celda);
  }
  tableBody.append(row);
  return tableBody;
}

function getTitleTable() {
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
    this.classList.remove("modal--show");
    reiniciar();
  }
});

function reiniciar() {
  $form.elements["cedula"].value = "";
  $form.elements["nombres"].value = "";
  $form.elements["apellidos"].value = "";
  $form.elements["telefono"].value = "";
}

function alertMensaje(sms = "Mensaje del sistema") {
  $modal.querySelector(".modal-table").innerHTML = "";
  $modal.querySelector(".modal-parrafo").textContent = sms;
  $modal.classList.add("modal--show");
}
