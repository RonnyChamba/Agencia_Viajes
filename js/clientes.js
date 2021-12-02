import { ajax, createQueryString } from "./ajax.js";
const $form = document.forms["form-insert-clientes"];
const $modal = document.getElementById("modal");
$form.addEventListener("submit", function (event) {
  preInsert(event, this);
});
async function preInsert(event, form) {
  event.preventDefault();
  let cedula = form.elements["cedula"].value;
  let queryString = createQueryString({ cedula });
  const { xhr, estado } = await ajax(
    `../php/consulta-existe.php?${queryString}`
  );
  let data = JSON.parse(xhr.responseText);
  if (estado) {
    if (data === null) guardar(form);
    else
      alertMensaje(
        `Cliente con la cédula  ${cedula} ya se encuentra registrado`
      );
  }
}

function obtenerValores(form) {
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

async function guardar(form) {
  let queryString = createQueryString(obtenerValores(form));
  const retr = await ajax(
    `../php/php-sql-insert/sql-insert-clientes.php?${queryString}`
  );
  const data = JSON.parse(retr.xhr.responseText);
  let persona = data.persona;
  createTable(JSON.parse(persona));
}

function createTable(cliente) {
  let table = document.createElement("TABLE");
  table.classList.add("table");
  table.appendChild(getHeadTable());
  table.appendChild(getBodyTable(cliente));
  $modal.querySelector(".modal-table").innerHTML = "";
  $modal.querySelector(".modal-table").appendChild(table);
  $modal.querySelector(".modal-parrafo").textContent =
    "Cliente guardado correctamente.";
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

function getBodyTable(cliente) {
  let tableBody = document.createElement("TBODY");
  tableBody.classList.add("table-body");
  let row = document.createElement("TR");
  for (const key in getTitleTable()) {
    let celda = document.createElement("TD");
    celda.classList.add("table-celd", "table-celd--td");
    celda.textContent = cliente[key];
    row.appendChild(celda);
  }
  tableBody.append(row);
  return tableBody;
}

function getTitleTable() {
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
  $form.elements["direccion"].value = "";
  $form.elements["edad"].value = "";
  $form.elements["nacionalidad"].value = "";
  // $form.elements["estado"];
  $form.elements["telefono"].value = "";
  $form.elements["estudios"].value = "";
}

function alertMensaje(sms = "Mensaje del sistema") {
  $modal.querySelector(".modal-table").innerHTML = "";
  $modal.querySelector(".modal-parrafo").textContent = sms;
  $modal.classList.add("modal--show");
}
