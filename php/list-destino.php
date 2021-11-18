<?php
  include('../conexion.php');
  $sql=("SELECT  DESTINO_COD, DESTINO_LUG, DESTINO_DIR, DESTINO_CIU, DESTINO_PAI,
          TIPO_VIAJE_TIP, TIPO_VIAJE_DES, TIPO_VIAJE_PRE
          FROM DESTINO
          INNER JOIN TIPO_VIAJE ON DESTINO_FK_TI_V = TIPO_VIAJE_COD");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Destinos</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  
  <div class="container">
    <section class="content content--header">
      <header class="header">
        <h1 class="title">Destinos Registrados</h1>
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
         <th class="table-celd table-celd--th">Destino</th>
         <th class="table-celd table-celd--th">Direcci&oacute;n</th>
         <th class="table-celd table-celd--th">Ciudad</th>
        <th class="table-celd table-celd--th">Pais</th>
        <th class="table-celd table-celd--th">Tipo</th>
         <th class="table-celd table-celd--th">Precio</th>
      </tr>
    </thead>
    <tbody class="table-body">
     <?php
          while($fila=mysqli_fetch_assoc($resultado))
       {
      ?>

      <tr>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['DESTINO_COD']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['DESTINO_LUG']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['DESTINO_DIR']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['DESTINO_CIU']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['DESTINO_PAI']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['TIPO_VIAJE_TIP']?>   </td>
          <td class="table-celd table-celd-td"> <?php echo "".$fila['TIPO_VIAJE_PRE']?> </td>
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