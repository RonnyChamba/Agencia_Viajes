<?php
// Recibir objeto como string
$data = $_GET['data'];

// Convertir
$arreglo = json_decode($data, true);
?>

  <table class="table">
    <input type="hidden" name="filtro-cedula" value="<?php echo "".$arreglo['CLIENTES_CED']?>">
    <thead class="table-head">
      <tr>
         <th class="table-celd table-celd--th">C&eacute;dula</th>
         <th class="table-celd table-celd--th">Nombres</th>
         <th class="table-celd table-celd--th">Direcci&oacute;n</th>
         <th class="table-celd table-celd--th">Edad</th>
         <th class="table-celd table-celd--th">Nacionalidad</th>
         <th class="table-celd table-celd--th">Estado</th>
         <th class="table-celd table-celd--th">Tel&eacute;fono</th>
         <th class="table-celd table-celd--th">Estudios</th>
         <!-- <th class="table-celd table-celd--th"></th> -->
      </tr>
    </thead>
    <tbody class="table-body">
      <tr>
        <td class="table-celd table-celd-td"> <?php echo "".$arreglo['CLIENTES_CED']?> </td>
        <td class="table-celd table-celd-td"> <?php echo "".$arreglo['CLIENTES_NOM']." ".$arreglo['CLIENTES_APE']  ?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$arreglo['CLIENTES_DIR']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$arreglo['CLIENTES_EDA']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$arreglo['CLIENTES_NAC']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$arreglo['CLIENTES_ES_C']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$arreglo['CLIENTES_TEL']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$arreglo['CLIENTES_ES_R']?>   </td>
      </tr>
    </tbody>
    </table>

    <div class="row row--flex">
      <input type="submit" value="Confirmar" class="btn btn--send" />
     <p class="btn btn--close" id="modal-close">Cancelar</p>
    </div>