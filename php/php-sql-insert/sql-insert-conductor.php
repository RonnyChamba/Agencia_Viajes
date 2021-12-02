<?php
 include('../../conexion.php');
$cedula = $_GET['cedula'];
$nombres = strtoupper($_GET['nombres']);
$apellidos = strtoupper ($_GET['apellidos']);
$telefono = $_GET['telefono'];

$sql = "INSERT INTO `agencia_viajes`.`conductor`
(`CONDUCTOR_CED`,
`CONDUCTOR_NOM`, 
`CONDUCTOR_APE`,
`CONDUCTOR_TEL`)
VALUES
('$cedula',
'$nombres',
'$apellidos',
'$telefono')";
$resultado = mysqli_query($conexion, $sql);

$data = [
  "estado" => $resultado
];
if ($resultado){
    $sql = "SELECT * FROM CONDUCTOR WHERE CONDUCTOR_CED LIKE '$cedula'";
   $stm = mysqli_query($conexion, $sql);
   $resultSet = mysqli_fetch_assoc($stm);
   $data["persona"] = json_encode($resultSet);
  
  }
  mysqli_close($conexion);
  echo json_encode($data);

