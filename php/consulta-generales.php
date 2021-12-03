<?php
  include('../conexion.php');
  try{

    $tabla =$_GET['tabla'];
    $sql ="SELECT * FROM  {$tabla}";
    $data = [];
    if ( $resultado=mysqli_query($conexion,$sql)){
        while ( $resultSet = mysqli_fetch_assoc($resultado)) {
        array_push($data, $resultSet);
      }
     }
     echo  json_encode ($data);
  }catch(Exception $error){ 
    echo "Eror jeje:".$error->getMessage();
  }

?>