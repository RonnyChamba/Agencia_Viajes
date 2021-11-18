<?php
  include('../conexion.php');
  $sql=("SELECT  FACTURA_COD, FACTURA_FEC, FACTURA_SUB, FACTURA_TOT, COMPRA_COD,
                 COMPRA_NU_B,
                 TIPO_VIAJE_PRE,
                 CLIENTES_NOM, CLIENTES_APE,
                DESTINO_LUG
                FROM FACTURA
                INNER JOIN COMPRA ON COMPRA_COD = FACTURA_FK_COM
                INNER JOIN CLIENTES  ON CLIENTES_CED = COMPRA_FK_CLI
                INNER JOIN DESTINO ON   DESTINO_COD = COMPRA_FK_DES
                INNER JOIN TIPO_VIAJE ON TIPO_VIAJE_COD = DESTINO_FK_TI_V");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Facturas</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  
  <div class="container">
    <section class="content content--header">
      <header class="header">
        <h1 class="title">Facturas Registradas</h1>
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
          <th class="table-celd table-celd--th">Precio</th>
         <th class="table-celd table-celd--th">Cliente</th>
         <th class="table-celd table-celd--th">Destino</th>
          <th class="table-celd table-celd--th">SubTotal</th>
           <th class="table-celd table-celd--th">Total</th>
            <th class="table-celd table-celd--th"></th>
      </tr>
    </thead>
    <tbody class="table-body">
     <?php
          while($fila=mysqli_fetch_assoc($resultado))
       {
      ?>

      <tr>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['FACTURA_COD']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['FACTURA_FEC']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['COMPRA_NU_B']?>   </td>
         <td class="table-celd table-celd-td"> <?php echo "".$fila['TIPO_VIAJE_PRE']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['CLIENTES_NOM']." ".$fila['CLIENTES_APE']  ?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['DESTINO_LUG']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['FACTURA_SUB']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['FACTURA_TOT']?>   </td>
        <td class="table-celd table-celd-td"> <a href = "list-compra.php?action=individual&cod=<?php echo "".$fila['COMPRA_COD']?>" class="btn">Ver Compra</a>  </td>
  
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