<?php
  include('../conexion.php');
  $isExist=  isset($_POST["action"]);
   if (!$isExist) $isExist = isset($_GET["action"]);
  $typeAction = "";
   if($isExist) {
    $param = "";
    if ($_REQUEST['action'] =="search"){
       $paramCampo = $_POST['select-filtro'];
       $param = $_POST["busqueda"];
       $typeAction = "WHERE {$paramCampo} LIKE '{$param}'";
    }else{
        $param = $_GET['dni'];
        $typeAction = " WHERE CONDUCTOR_CED = {$param} ";
    } 
  }
  $numeroRegistros =0;  
  $sql=("SELECT * FROM CONDUCTOR  {$typeAction}");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Conductores</title>
   <link
      href="https://file.myfontastic.com/JUwFAwWE8oUWFGdiTZSWaX/icons.css"
      rel="stylesheet"
    />
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  
  <div class="container">
    <section class="content content--header">
      <header class="header header--flex">
        <h1 class="title">
          <?php echo $isExist?"Mis Datos Conductor":"Conductores Registrados" ?>   
        
        </h1>
          <p class="icon-github">
            <a href="https://github.com/RonnyChamba/Agencia_Viajes" target="_blank" class="link">Descargar Proyecto</a>
          </p>
      </header>
    </section>
    <section class="content content--main">

    <?php
      if($resultado= mysqli_query($conexion, $sql))
   {
     
      echo "<p class ='datos'> <a  href='list-conductor.php' class ='btn btn--datos'>Ver Todos Conductores</a> </p>";
      
    ?>
    <table class="table">

    <thead class="table-head">
      <tr>
         <th class="table-celd table-celd--th">C&eacute;dula</th>
         <th class="table-celd table-celd--th">Nombres</th>
         <th class="table-celd table-celd--th">Tel&eacute;fono</th>
         <th class="table-celd table-celd--th">Licencias</th>
      </tr>
    </thead>
    <tbody class="table-body">
     <?php
          while($fila=mysqli_fetch_assoc($resultado))
       {
            $numeroRegistros +=1;
      ?>

      <tr>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['CONDUCTOR_CED']?> </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['CONDUCTOR_NOM']." ".$fila['CONDUCTOR_APE']  ?>   </td>
        <td class="table-celd table-celd-td"> <?php echo "".$fila['CONDUCTOR_TEL']?>   </td>
        <td class="table-celd table-celd-td"> <a href = "list-licencias.php?action=individual&dni=<?php echo "".$fila['CONDUCTOR_CED']?>" class="btn btn--table">Mis Licencias</a></td>
      </tr>
      <?php }?>


    </tbody>
    </table>
     <?php
      if ($numeroRegistros==0) echo "<p class= 'datos datos-no-registros'>No hay Conductores para mostrar</p>";    
    ?>
      <p class="datos"> <span class="numero-registros">  Numero de registros:  <?php  echo "".$numeroRegistros ?></span></p>
    <?php }else{

      echo "<p>Surgio un error al consultar los datos</p>";
    } ?>
    <p> <a href="/index.html" class="link link--return">Regresar al menú</a></p>
    </section>
  </div>
</body>
</html>