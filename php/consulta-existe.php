<?php
  include('../conexion.php');
  try{

    $sql ="";
    $tabla =$_GET['tabla'];
    $filtro =$_GET['filtro'];

    if ($tabla=="empleados") {
      $sql ="SELECT * FROM EMPLEADOS WHERE EMPLEADOS_CED LIKE '$filtro'";
    }else if ($tabla=="clientes"){
      $sql ="SELECT * FROM CLIENTES WHERE CLIENTES_CED LIKE '$filtro'"; 
    }else if ($tabla=="tipo-transporte"){
      $sql ="SELECT * FROM TIPO_TRANSPORTE WHERE TIPO_TRANSPORTE_NOM LIKE '$filtro'"; 
    }

    $stm = mysqli_query($conexion,$sql);
    
    $resultSet = mysqli_fetch_assoc($stm);
    echo json_encode($resultSet);
  }catch(Exception $error){
    echo "Eror jeje:".$error->getMessage();
  }

?>