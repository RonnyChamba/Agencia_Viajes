<?php
  include('../conexion.php');
  try{

    $sql ="";
    if (isset($_GET['dni'])) {
      $cedula = $_GET['dni'];
      $sql ="SELECT * FROM CLIENTES WHERE CED_CLI LIKE '{$cedula}'";
    }else{
      $sql ="SELECT * FROM CLIENTES WHERE CLIENTES_CED LIKE '{$_GET['cedula']}'"; 
    }

    $stm = mysqli_query($conexion,$sql);
    
    $resultSet = mysqli_fetch_assoc($stm);
    echo json_encode($resultSet);
  }catch(Exception $error){
    echo "Eror jeje:".$error->getMessage();
  }

?>