<?php
  include('../conexion.php');
    $numeroRegistros =0; 
  $sql=("SELECT TRANSPORTE_COD, TRANSPORTE_MAT, TRANSPORTE_COL, TRANSPORTE_AG_F,
                TIPO_TRANSPORTE_NOM, TIPO_TRANSPORTE_ASI,
                CONDUCTOR_NOM, CONDUCTOR_APE 
                FROM TIPO_TRANSPORTE
                INNER JOIN TRANSPORTE ON TRANSPORTE_FK_TI_T= TIPO_TRANSPORTE_COD
                INNER JOIN CONDUCTOR ON TRANSPORTE_FK_CON= CONDUCTOR_CED");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transporte</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  
  <div class="container">
    <section class="content content--header">
      <header class="header">
        <h1 class="title">Transportes Registrados</h1>
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
         <th class="table-celd table-celd--th">Tipo</th>
         <th class="table-celd table-celd--th">Matricula</th>
         <th class="table-celd table-celd--th">Color</th>
         <th class="table-celd table-celd--th">Año</th>
         <th class="table-celd table-celd--th">Asientos</th>
          <th class="table-celd table-celd--th">Conductor</th>
      </tr>
    </thead>
    <tbody class="table-body">
     <?php
          while($fila=mysqli_fetch_assoc($resultado))
       {
           $numeroRegistros +=1;
      ?>

      <tr>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['TRANSPORTE_COD']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['TIPO_TRANSPORTE_NOM']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['TRANSPORTE_MAT']?> </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['TRANSPORTE_COL']?> </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['TRANSPORTE_AG_F']?> </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['TIPO_TRANSPORTE_ASI']?></td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['CONDUCTOR_NOM']." ".$fila['CONDUCTOR_APE']?></td>
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