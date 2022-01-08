<?php
// Recibir objeto como string
$data = $_GET['data'];

// Convertir
$arreglo = json_decode($data, true);
?>
 <table class="table">
     <input type="hidden" name="filtro-cedula" value="<?php echo "".$arreglo['CONDUCTOR_CED']?>">
    <thead class="table-head">
      <tr>
         <th class="table-celd table-celd--th">C&eacute;dula</th>
         <th class="table-celd table-celd--th">Nombres</th>
         <th class="table-celd table-celd--th">Tel&eacute;fono</th>
      </tr>
    </thead>
    <tbody class="table-body">
      <tr>
        
      <td class="table-celd table-celd-td"> <?php echo "".$arreglo['CONDUCTOR_CED']?> </td>
        <td class="table-celd table-celd-td"> <?php echo "".$arreglo['CONDUCTOR_NOM']." ".$arreglo['CONDUCTOR_APE']  ?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$arreglo['CONDUCTOR_TEL']?> </td>
      </tr>
    </tbody>
    </table>

    <div class="row row--flex">
      <input type="submit" value="Confirmar" class="btn btn--send" />
     <p class="btn btn--close" id="modal-close">Cancelar</p>
    </div>