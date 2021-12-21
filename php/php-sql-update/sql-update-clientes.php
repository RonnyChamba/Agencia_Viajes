<?php
 include('../../conexion.php');
$cedula = $_GET['cedula'];
$nombres = strtoupper($_GET['nombres']);
$apellidos = strtoupper ($_GET['apellidos']);
$direccion = strtoupper( $_GET['direccion']);
$edad =$_GET['edad'];
$nacionalidad =strtoupper($_GET['nacionalidad']);
$estado = $_GET['estado'];
$telefono = $_GET['telefono'];
$estudios =  strtoupper($_GET['estudios']);

$sql = "UPDATE  CLIENTES SET CLIENTES_NOM = '$nombres', CLIENTES_APE = '$apellidos', CLIENTES_DIR = '$direccion',
CLIENTES_EDA =  '$edad', CLIENTES_NAC = '$nacionalidad',  CLIENTES_ES_C = '$estado', CLIENTES_TEL  = '$telefono', CLIENTES_ES_R = '$estudios'
WHERE CLIENTES_CED = '$cedula' ";
$resultado = mysqli_query($conexion, $sql);

$data = [
  "estado" => $resultado,
  "mensaje" => $resultado? 'Clientes actualizado correctamente':"No se pudo actualizar los datos"
];
// if ($resultado){
//     $sql = "SELECT * FROM EMPLEADOS WHERE EMPLEADOS_CED LIKE '$cedula'";
//    $stm = mysqli_query($conexion, $sql);
//    $resultSet = mysqli_fetch_assoc($stm);
//    $data["persona"] = json_encode($resultSet);
  
//   }
  mysqli_close($conexion);
  echo json_encode($data);