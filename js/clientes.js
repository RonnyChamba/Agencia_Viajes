import { ajax } from "./ajax.js";
const $form = document.forms["form-insert-clientes"];
$form.addEventListener("submit", function (event) {
  preInsert(event, this);
});
async function preInsert(event, form) {
  event.preventDefault();
  let cedula = form.elements["cedula"].value;
  const { xhr, estado } = await ajax(
    `../php/consulta-existe.php?cedula=${cedula}`
  );

  if (estado) {
    let data = JSON.parse(xhr.responseText);
    if (data === null) {
      alert("Es nuevo");
      form.submit();
    } else {
      alert("Cliente ya existe");
      // Abrir modal
    }
  }
}

function validarInformacion(params) {}
