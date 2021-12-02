<?php
 include('../../conexion.php');

$cedula = $_POST['cedula'];
$nombres = strtoupper($_POST['nombres']);
$apellidos = strtoupper ($_POST['apellidos']);
$direccion = strtoupper( $_POST['direccion']);
$edad = $_POST['edad'] ==""? "0": $_POST['edad'];
$nacionalidad =strtoupper($_POST['nacionalidad']);
$estado = $_POST['estado'];
$telefono = $_POST['telefono'];
$estudios =  strtoupper($_POST['estudios']);
echo "{$cedula}";
echo "{$nombres}";
echo "{$apellidos}";
echo "{$direccion}";
echo "{$edad}";
echo "{$nacionalidad}";
echo "{$estado}";
echo "{$telefono}";
echo "{$estudios}";



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
mysqli_close($conexion);
