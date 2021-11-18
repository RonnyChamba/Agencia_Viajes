<?php
  include('../conexion.php');
  $sql=("SELECT * FROM CLIENTES");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clientes</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  
  <div class="container">
    <section class="content content--header">
      <header class="header">
        <h1 class="title">Clientes Registrados</h1>
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
         <th class="table-celd table-celd--th">C&eacute;dula</th>
         <th class="table-celd table-celd--th">Nombres</th>
         <th class="table-celd table-celd--th">Direcci&oacute;n</th>
         <th class="table-celd table-celd--th">Edad</th>
         <th class="table-celd table-celd--th">Nacionalidad</th>
         <th class="table-celd table-celd--th">Estado</th>
         <th class="table-celd table-celd--th">Tel&eacute;fono</th>
         <th class="table-celd table-celd--th">Estudios</th>
      </tr>
    </thead>
    <tbody class="table-body">
     <?php
          while($fila=mysqli_fetch_assoc($resultado))
       {
      ?>

      <tr>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['CLIENTES_CED']?> </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['CLIENTES_NOM']." ".$fila['CLIENTES_APE']  ?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['CLIENTES_DIR']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['CLIENTES_EDA']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['CLIENTES_NAC']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['CLIENTES_ES_C']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['CLIENTES_TEL']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['CLIENTES_ES_R']?>   </td>
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