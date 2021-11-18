<?php
  include('../conexion.php');
  $sql=("SELECT  COMPRA_COD, COMPRA_FEC, COMPRA_NU_B,
                 CLIENTES_NOM, CLIENTES_APE,
                 DESTINO_LUG,
                 TIPO_VIAJE_TIP,
                 TRANSPORTE_COL,
                 TIPO_TRANSPORTE_NOM,
                 CONDUCTOR_NOM, CONDUCTOR_APE,
                 EMPLEADOS_NOM, EMPLEADOS_APE  
                 FROM COMPRA
                 INNER JOIN CLIENTES  ON CLIENTES_CED = COMPRA_FK_CLI
                 INNER JOIN EMPLEADOS ON EMPLEADOS_CED = COMPRA_FK_EMP
                 INNER JOIN TRANSPORTE ON TRANSPORTE_COD = COMPRA_FK_TRA
                 INNER JOIN DESTINO ON   DESTINO_COD = COMPRA_FK_DES
                 INNER JOIN TIPO_VIAJE ON TIPO_VIAJE_COD = DESTINO_FK_TI_V
                 INNER JOIN TIPO_TRANSPORTE ON TIPO_TRANSPORTE_COD = TRANSPORTE_FK_TI_T
                 INNER JOIN CONDUCTOR ON CONDUCTOR_CED  = TRANSPORTE_FK_CON");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compra</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  
  <div class="container">
    <section class="content content--header">
      <header class="header">
        <h1 class="title">Compras Viajes Registrados</h1>
      </header>
    </section>
    <section class="content content--main">

    <?php
      if($resultado= mysqli_query($conexion, $sql))
   {
    ?>
    <table class="table">

    <thead class="table-head">
      <tr>
         <th class="table-celd table-celd--th">C&oacute;digo</th>
        <th class="table-celd table-celd--th">Fecha</th>
         <th class="table-celd table-celd--th">Boletos</th>
         <th class="table-celd table-celd--th">Cliente</th>
         <th class="table-celd table-celd--th">Destino</th>
        <th class="table-celd table-celd--th">Viaje</th>
         <th class="table-celd table-celd--th">Transporte</th>
         <th class="table-celd table-celd--th">Conductor</th>
         <th class="table-celd table-celd--th">Empleado</th>
      </tr>
    </thead>
    <tbody class="table-body">
     <?php
          while($fila=mysqli_fetch_assoc($resultado))
       {
      ?>

      <tr>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['COMPRA_COD']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['COMPRA_FEC']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['COMPRA_NU_B']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['CLIENTES_NOM']." ".$fila['CLIENTES_APE']  ?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['DESTINO_LUG']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['TIPO_VIAJE_TIP']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['TIPO_TRANSPORTE_NOM']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['CONDUCTOR_NOM']." ".$fila['CONDUCTOR_APE']  ?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['EMPLEADOS_NOM']." ".$fila['EMPLEADOS_APE']  ?>   </td>
  
      </tr>
      <?php }?>
    </tbody>
    </table>
    <?php }else{

      echo "<p>Surgio un error al consultar los datos</p>";
    } ?>
    <p> <a href="/index.html" class="link link--return">Regresar al menú</a></p>
    </section>
  </div>
</body>
</html>