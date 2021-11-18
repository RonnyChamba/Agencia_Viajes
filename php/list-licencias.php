<?php
  include('../conexion.php');
  $sql=("SELECT  LICENCIA_TIP, LICENCIA_FE_I, LICENCIA_FE_F,
                 CONDUCTOR_CED, CONDUCTOR_NOM, CONDUCTOR_APE 
                 FROM LICENCIA
                 INNER JOIN CONDUCTOR ON CONDUCTOR_CED= LICENCIA_FK_CON");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Licencias</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  
  <div class="container">
    <section class="content content--header">
      <header class="header">
        <h1 class="title">Licencias Registradas Conductores</h1>
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
         <th class="table-celd table-celd--th">Tipo</th>
         <th class="table-celd table-celd--th">Fecha Expedici&oacute;n</th>
         <th class="table-celd table-celd--th">Fecha Expiraci&oacute;n</th>
         <th class="table-celd table-celd--th">Conductor</th>
        <th class="table-celd table-celd--th"></th>
      </tr>
    </thead>
    <tbody class="table-body">
     <?php
          while($fila=mysqli_fetch_assoc($resultado))
       {
      ?>

      <tr>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['LICENCIA_TIP']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['LICENCIA_FE_I']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['LICENCIA_FE_F']?>   </td>
         <td class="table-celd table-celd-td"> <?php echo "".$fila['CONDUCTOR_NOM']." ".$fila['CONDUCTOR_APE']  ?>   </td>
        <td class="table-celd table-celd-td"> <a href= "list-conductor.php?action=individual&dni=<?php echo "".$fila['CONDUCTOR_CED']?>" class="btn" >Ver Conductor</a></td>
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