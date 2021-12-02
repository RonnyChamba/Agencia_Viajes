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

$sql = "INSERT INTO `agencia_viajes`.`empleados`
(`EMPLEADOS_CED`,
`EMPLEADOS_NOM`, 
`EMPLEADOS_APE`,
`EMPLEADOS_DIR`,
`EMPLEADOS_EDA`,
`EMPLEADOS_ES_C`,
`EMPLEADOS_TEL`,
`EMPLEADOS_SAL`)
VALUES
('$cedula',
'$nombres',
'$apellidos',
'$direccion',
'$edad',
'$estado',
'$telefono',
'$salario')";
$resultado = mysqli_query($conexion, $sql);

$data = [
  "estado" => $resultado
];
if ($resultado){
    $sql = "SELECT * FROM EMPLEADOS WHERE EMPLEADOS_CED LIKE '$cedula'";
   $stm = mysqli_query($conexion, $sql);
   $resultSet = mysqli_fetch_assoc($stm);
   $data["persona"] = json_encode($resultSet);
  
  }
  mysqli_close($conexion);
  echo json_encode($data);

