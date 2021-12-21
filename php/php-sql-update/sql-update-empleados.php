<?php
 include('../../conexion.php');
$cedula = $_GET['cedula'];
$nombres = strtoupper($_GET['nombres']);
$apellidos = strtoupper ($_GET['apellidos']);
$direccion = strtoupper( $_GET['direccion']);
$edad =$_GET['edad'];
$estado = $_GET['estado'];
$telefono = $_GET['telefono'];
$salario =  $_GET['sueldo'];


$sql = "UPDATE  EMPLEADOS SET EMPLEADOS_NOM = '$nombres', EMPLEADOS_APE = '$apellidos', EMPLEADOS_DIR = '$direccion',
EMPLEADOS_EDA =  '$edad', EMPLEADOS_ES_C = '$estado', EMPLEADOS_TEL  = '$telefono', EMPLEADOS_SAL = '$salario'
WHERE EMPLEADOS_CED = '$cedula' ";
$resultado = mysqli_query($conexion, $sql);

$data = [
  "estado" => $resultado,
  "mensaje" => $resultado? 'Empleado actualizado correctamente':"No se pudo actualizar los datos"
];
// if ($resultado){
//     $sql = "SELECT * FROM EMPLEADOS WHERE EMPLEADOS_CED LIKE '$cedula'";
//    $stm = mysqli_query($conexion, $sql);
//    $resultSet = mysqli_fetch_assoc($stm);
//    $data["persona"] = json_encode($resultSet);
  
//   }
  mysqli_close($conexion);
  echo json_encode($data);