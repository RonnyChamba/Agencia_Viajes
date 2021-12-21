import { ajax, createQueryString } from "./ajax.js";
const $d = document;
const $form = $d.forms["form-search"];
const $selectTablas = $form["select-tabla"];
const $selectFiltro = $form["select-filtro"];
const $modal = document.getElementById("modal");

const $formModal = $d.forms["form-update"];
console.log($formModal);

$formModal.addEventListener("submit", function (event) {
  event.preventDefault();

  console.log(event);
});
$selectTablas.addEventListener("click", () => selectedOption());
$form.addEventListener("submit", function (event) {
  event.preventDefault();
  let index = $selectTablas.selectedIndex;
  if (index != -1) {
    let tablaSelected = $selectTablas.children[index].value;
    let filtro = $form["busqueda"].value;
    buscar(tablaSelected, filtro);
    //let file = files[tablaSelected];
    // this.setAttribute("action", `php/${file}`);
    // this.submit();
    return;
  }
  alert("Seleccione una tabla");
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
const files = {
  EMPLEADOS: "list-empleados.php",
  //TIPO_VIAJE: "list-tipo-viaje.php",
  //LICENCIA: "list-licencias.php",
  //DESTINO: "list-destino.php",
  CLIENTES: "list-clientes.php",
  //TIPO_TRANSPORTE: "list-tipo-transporte.php",
  CONDUCTOR: "list-conductor.php",
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

function buscar(tabla, parametro = "") {
  switch (tabla) {
    case "EMPLEADOS":
      buscarEmpleado(parametro);
      break;
    case "CLIENTES":
      buscarCliente(parametro);
      break;
    case "CONDUCTOR":
      buscarConductor(parametro);
      break;

    default:
      alert("No existe la tabla ", tabla);
      break;
  }
}

async function buscarEmpleado(filtro) {
  // filtro = "0000000066";
  let queryString = createQueryString({ filtro, tabla: "empleados" });
  const { xhr, estado } = await ajax(
    `../php/consulta-existe.php?${queryString}`
  );
  let data = JSON.parse(xhr.responseText);
  if (data) {
    queryString = createQueryString({ data: JSON.stringify(data) });
    // Peticion haci archivos form update
    const formulario = await ajax(
      `../php/php-view-update/view-update-empleados.php?${queryString}`
    );

    let formUpdate = formulario.xhr.responseText;
    $formModal.innerHTML = formUpdate;
    $modal.querySelector("#modal-subtitle").textContent = "Actualizar Empleado";
    $modal.classList.add("modal--show");
  } else alert(`El empleado con la cédula ${filtro} no existe`);
}

function buscarCliente(filtro) {}
function buscarConductor(filtro) {}
