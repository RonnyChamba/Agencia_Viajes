<?php
 include('../../conexion.php');
$nombre = strtoupper($_GET['nombre']);
$precio= $_GET['precio'];
$descripcion= strtoupper($_GET['descripcion']);

$sql = "INSERT INTO `agencia_viajes`.`tipo_viaje`
(`TIPO_VIAJE_TIP`,
`TIPO_VIAJE_DES`,
`TIPO_VIAJE_PRE`)
VALUES
('$nombre',
'$descripcion',
'$precio')";
$resultado = mysqli_query($conexion, $sql);

$data = [
  "estado" => $resultado
];
if ($resultado){
    $sql = "SELECT * FROM TIPO_VIAJE WHERE TIPO_VIAJE_TIP LIKE '$nombre'";
   $stm = mysqli_query($conexion, $sql);
   $resultSet = mysqli_fetch_assoc($stm);
   $data["objeto"] = json_encode($resultSet);
  
  }
  mysqli_close($conexion);
  echo json_encode($data);

