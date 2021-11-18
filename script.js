const $d = document;
const $form = $d.forms["form-search"];
const $selectTablas = $form["select-tabla"];
const $selectFiltro = $form["select-filtro"];

$selectTablas.addEventListener("click", () => selectedOption());

const tablas = {
  EMPLEADOS: "EMPLEADOS",
  TIPO_VIAJE: "TIPO VIAJES",
  LICENCIA: "LICENCIAS",
  DESTINO: "DESTINOS",
  CLIENTES: "CLIENTES",
  TIPO_TRANSPORTE: "TIPO TRANSPORTE",
  CONDUCTOR: "CONDUCTORES",
  TRANSPORTE: "TRANSPORTES",
  COMPRA: "COMPRAS",
  FACTURA: "FACTURAS",
};
const filtros = {
  CLIENTES: {
    CLIENTES_CED: "CEDULA",
    CLIENTES_NOM: "NOMBRE",
    CLIENTES_APE: "APELLIDO",
  },
  EMPLEADOS: {
    EMPLEADOS_CED: "CEDULA",
    EMPLEADOS_NOM: "NOMBRE",
    EMPLEADOS_APE: "APELLIDO",
  },
  TIPO_TRANSPORTE: {
    TIPO_TRANSPORTE_TIP: "TIPO",
  },
  TIPO_VIAJE: {
    TIPO_VIAJE: "TIPO",
  },
  CONDUCTOR: {
    CONDUCTOR_CED: "CEDULA",
    CONDUCTOR_NOM: "NOMBRE",
    CONDUCTOR_APE: "APELLIDO",
  },
  LICENCIA: {
    LICENCIA_TIP: "TIPO",
    LICENCIA_FK_CON: "CONDUCTOR",
  },
  TRANSPORTE: {
    TRANSPORTE_MAT: "MATRICULA",
    TRANSPORTE_COL: "COLOR",
  },
  DESTINO: {
    DESTINO_LUG: "LUGAR",
    DESTINO_CIU: "CIUDAD",
  },
  COMPRA: {
    COMPRA_COD: "CODIGO",
  },
  FACTURA: {
    FACTURA_COD: "CODIGO",
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
  console.log("Tabla no existe");
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
