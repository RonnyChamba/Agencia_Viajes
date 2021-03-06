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
    }
  }
  $numeroRegistros =0; 
  $sql=("SELECT TRANSPORTE_COD, TRANSPORTE_MAT, TRANSPORTE_COL, TRANSPORTE_AG_F,
                TIPO_TRANSPORTE_NOM, TIPO_TRANSPORTE_ASI,
                CONDUCTOR_NOM, CONDUCTOR_APE 
                FROM TIPO_TRANSPORTE
                INNER JOIN TRANSPORTE ON TRANSPORTE_FK_TI_T= TIPO_TRANSPORTE_COD
                INNER JOIN CONDUCTOR ON TRANSPORTE_FK_CON= CONDUCTOR_CED {$typeAction}");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transporte</title>
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
        <h1 class="title">Transportes Registrados</h1>
          <p class="icon-github">
            <a href="https://github.com/RonnyChamba/Agencia_Viajes" target="_blank" class="link">Descargar Proyecto</a>
          </p>
      </header>
    </section>
    <section class="content content--main">

    <?php
      if($resultado= mysqli_query($conexion, $sql))
   {
      echo "<p class ='datos'> <a  href='list-transporte.php' class ='btn btn--datos'>Ver Todos Transportes</a> </p>";
    ?>
    <table class="table">

    <thead class="table-head">
      <tr>
         <th class="table-celd table-celd--th">C&oacute;digo</th>
         <th class="table-celd table-celd--th">Tipo</th>
         <th class="table-celd table-celd--th">Matricula</th>
         <th class="table-celd table-celd--th">Color</th>
         <th class="table-celd table-celd--th">A??o</th>
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
     <?php
      if ($numeroRegistros==0) echo "<p class= 'datos datos-no-registros'>No hay Transportes para mostrar</p>";    
    ?>
    <p class="datos"> <span class="numero-registros">  Numero de registros:  <?php  echo "".$numeroRegistros ?></span></p>
    <?php }else{

      echo "<p>Surgio un error al consultar los datos</p>";
    } ?>
    <p> <a href="/index.html" class="link link--return">Regresar al men??</a></p>
    </section>
  </div>
</body>
</html>