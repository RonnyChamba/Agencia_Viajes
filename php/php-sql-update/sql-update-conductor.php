<?php
 include('../../conexion.php');
$cedula = $_GET['cedula'];
$nombres = strtoupper($_GET['nombres']);
$apellidos = strtoupper ($_GET['apellidos']);
$telefono = $_GET['telefono'];

$sql = "UPDATE CONDUCTOR  SET CONDUCTOR_NOM = '$nombres',  CONDUCTOR_APE = '$apellidos', 
CONDUCTOR_TEL = '$telefono' WHERE CONDUCTOR_CED = '$cedula' ";
$resultado = mysqli_query($conexion, $sql);

$data = [
  "estado" => $resultado,
   "mensaje" => $resultado? 'Conductor actualizado correctamente':"No se pudo actualizar los datos"
];
// if ($resultado){
//     $sql = "SELECT * FROM CONDUCTOR WHERE CONDUCTOR_CED LIKE '$cedula'";
//    $stm = mysqli_query($conexion, $sql);
//    $resultSet = mysqli_fetch_assoc($stm);
//    $data["persona"] = json_encode($resultSet);
  
//   }
  mysqli_close($conexion);
  echo json_encode($data);
