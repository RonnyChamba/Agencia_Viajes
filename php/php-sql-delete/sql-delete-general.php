<?php
 include('../../conexion.php');
$cedula = $_GET['cedula'];
$tabla = $_GET['tabla'];

$sql = "";

if ($tabla =="EMPLEADOS"){

  $sql ="DELETE FROM EMPLEADOS WHERE EMPLEADOS_CED = '$cedula'";
}else if($tabla =="CLIENTES"){
   $sql ="DELETE FROM CLIENTES WHERE CLIENTES_CED = '$cedula'";

}else if($tabla =="CONDUCTOR"){
   $sql ="DELETE FROM CONDUCTOR WHERE CONDUCTOR_CED = '$cedula'";
}

$resultado = mysqli_query($conexion, $sql);

$data = [
  "estado" => $resultado,
  "mensaje" => $resultado? 'Registro eliminado correctamente':"No se pudo eliminar el registro,  esta referenciado en otra tabla"
];

  mysqli_close($conexion);
  echo json_encode($data);