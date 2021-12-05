<?php
 include('../../conexion.php');
$boletos = $_GET['boletos'];
$cliente = $_GET['cliente'];
$destino = $_GET['destino'];
$transporte = $_GET['transporte'];
$empleado =$_GET['empleado'];

$sql = "INSERT INTO `agencia_viajes`.`compra`
(`COMPRA_FEC`,
`COMPRA_NU_B`, 
`COMPRA_FK_CLI`,
`COMPRA_FK_DES`,
`COMPRA_FK_TRA`,
`COMPRA_FK_EMP`)
VALUES
(CURDATE(),
'$boletos',
'$cliente',
'$destino',
'$transporte',
'$empleado')";
$resultado = mysqli_query($conexion, $sql);

$data = [
  "estado" => $resultado
];
if ($resultado){
    $sql = "SELECT  COMPRA_COD FROM COMPRA WHERE COMPRA_COD = (SELECT MAX(COMPRA_COD) FROM COMPRA)";
   $stm = mysqli_query($conexion, $sql);
   $resultSet = mysqli_fetch_assoc($stm);
   $data["objeto"] = json_encode($resultSet);
  
  }
  mysqli_close($conexion);
  echo json_encode($data);

