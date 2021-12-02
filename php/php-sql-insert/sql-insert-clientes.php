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

$sql = "INSERT INTO `agencia_viajes`.`clientes`
(`CLIENTES_CED`,
`CLIENTES_NOM`, 
`CLIENTES_APE`,
`CLIENTES_DIR`,
`CLIENTES_EDA`,
`CLIENTES_NAC`,
`CLIENTES_ES_C`,
`CLIENTES_TEL`,
`CLIENTES_ES_R`)
VALUES
('$cedula',
'$nombres',
'$apellidos',
'$direccion',
'$edad',
'$nacionalidad',
'${estado}',
'$telefono',
'$estudios')";
$resultado = mysqli_query($conexion, $sql);

$data = [
  "estado" => $resultado
];
if ($resultado){
    $sql = "SELECT * FROM CLIENTES WHERE CLIENTES_CED LIKE '$cedula'";
   $stm = mysqli_query($conexion, $sql);
   $resultSet = mysqli_fetch_assoc($stm);
   $data["persona"] = json_encode($resultSet);
  
  }
  mysqli_close($conexion);
  echo json_encode($data);

