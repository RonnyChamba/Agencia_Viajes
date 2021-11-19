<?php
  include('../conexion.php');
  
  $isExist=  isset($_POST["action"]);
  $typeAction = "";
   if($isExist) {
    $param = "";
    if ($_REQUEST['action'] =="search"){
       $paramCampo = $_POST['select-filtro'];
       $param = $_POST["busqueda"];
       $typeAction = "WHERE {$paramCampo} LIKE '{$param}'";
    }else{
        $param = $_GET['dni'];
        $typeAction = " WHERE EMPLEADOS_CED = {$param} ";
    }
  } 
  $numeroRegistros =0; 
  $sql=("SELECT * FROM EMPLEADOS {$typeAction}");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Empleados</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  
  <div class="container">
    <section class="content content--header">
      <header class="header">
        <h1 class="title">Empleados Registrados</h1>
      </header>
    </section>
    <section class="content content--main">

    <?php
      if($resultado= mysqli_query($conexion, $sql))
   {
     
    echo "<p class ='datos'> <a  href='list-empleados.php' class ='btn btn--datos'>Ver Todos Empleados</a> </p>";
      
    ?>
    <table class="table">

    <thead class="table-head">
      <tr>
         <th class="table-celd table-celd--th">C&eacute;dula</th>
         <th class="table-celd table-celd--th">Nombres</th>
         <th class="table-celd table-celd--th">Direcci&oacute;n</th>
         <th class="table-celd table-celd--th">Edad</th>
         <th class="table-celd table-celd--th">Estado</th>
         <th class="table-celd table-celd--th">Tel&eacute;fono</th>
         <th class="table-celd table-celd--th">Sueldo</th>
      </tr>
    </thead>
    <tbody class="table-body">
     <?php
          while($fila=mysqli_fetch_assoc($resultado))
       {
           $numeroRegistros +=1;
      ?>

      <tr>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['EMPLEADOS_CED']?> </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['EMPLEADOS_NOM']." ".$fila['EMPLEADOS_APE']  ?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['EMPLEADOS_DIR']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['EMPLEADOS_EDA']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['EMPLEADOS_ES_C']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['EMPLEADOS_TEL']?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['EMPLEADOS_SAL']?>   </td>
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