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
  $sql=("SELECT  DESTINO_COD, DESTINO_LUG, DESTINO_DIR, DESTINO_CIU, DESTINO_PAI,
          TIPO_VIAJE_TIP, TIPO_VIAJE_DES, TIPO_VIAJE_PRE
          FROM DESTINO
          INNER JOIN TIPO_VIAJE ON DESTINO_FK_TI_V = TIPO_VIAJE_COD {$typeAction}");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Destinos</title>
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
        <h1 class="title">Destinos Registrados</h1>
          <p class="icon-github">
            <a href="https://github.com/RonnyChamba/Agencia_Viajes" target="_blank" class="link">Descargar Proyecto</a>
          </p>
      </header>
    </section>
    <section class="content content--main">

    <?php
      if($resultado= mysqli_query($conexion, $sql))
      
   {
      echo "<p class ='datos'> <a  href='list-destino.php' class ='btn btn--datos'>Ver Todos Destinos</a> </p>";
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
           $numeroRegistros +=1;
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
         <?php
          if ($numeroRegistros==0) echo "<p class= 'datos datos-no-registros'>No hay Destinos para mostrar</p>";    
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