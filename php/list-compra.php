<?php
  include('../conexion.php');
  $typeAction = "";
  $title = "Compras Viajes Registrados";
  $isExist = isset($_GET['action']);
  $numeroRegistros =0; 
  if($isExist) {
    $param = $_GET['dni'];
    $typeAction ="WHERE ";
    if (isset($_GET['factura'])){
      $title ="Detalle Compra Factura";
      $typeAction = "{$typeAction} COMPRA_COD =";
    }else{
       $title ="Mis Compras Realizadas";
      $typeAction ="{$typeAction} CLIENTES_CED =";
    }
    $typeAction =  "{$typeAction} {$param}";
  } 
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
                 INNER JOIN CONDUCTOR ON CONDUCTOR_CED  = TRANSPORTE_FK_CON  {$typeAction}");
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
        <h1 class="title"> 
        <?php echo $title ?>        
          </h1>
      </header>
    </section>
    <section class="content content--main">

    <?php
      if($resultado= mysqli_query($conexion, $sql))
   {
      if ($isExist){
        echo "<p class ='datos'> <a  href='list-compra.php' class ='btn btn--datos'>Ver Todas Compras</a> </p>";
      }
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
         $numeroRegistros +=1;
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
    <p class="datos"> <span class="numero-registros">  Numero de registros:  <?php  echo "".$numeroRegistros ?></span></p>
    <?php }else{

      echo "<p>Surgio un error al consultar los datos</p>";
    } ?>
    <p> <a href="/index.html" class="link link--return">Regresar al menú</a></p>
    </section>
  </div>
</body>
</html>