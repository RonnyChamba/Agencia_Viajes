<?php
 include('../../conexion.php');
$nombre = strtoupper($_GET['nombre']);
$asientos= $_GET['asientos'];

$sql = "INSERT INTO `agencia_viajes`.`TIPO_TRANSPORTE`
(`TIPO_TRANSPORTE_NOM`,
`TIPO_TRANSPORTE_ASI`)
VALUES
('$nombre',
'$asientos')";
$resultado = mysqli_query($conexion, $sql);

$data = [
  "estado" => $resultado
];
if ($resultado){
    $sql = "SELECT * FROM TIPO_TRANSPORTE WHERE TIPO_TRANSPORTE_NOM LIKE '$nombre'";
   $stm = mysqli_query($conexion, $sql);
   $resultSet = mysqli_fetch_assoc($stm);
   $data["objeto"] = json_encode($resultSet);
  
  }
  mysqli_close($conexion);
  echo json_encode($data);

