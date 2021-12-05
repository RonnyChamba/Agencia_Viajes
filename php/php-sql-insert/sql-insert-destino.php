<?php
 include('../../conexion.php');
$lugar = strtoupper($_GET['lugar']);
$direccion= strtoupper($_GET['direccion']);
$ciudad= strtoupper($_GET['ciudad']);
$pais= strtoupper($_GET['pais']);
// Codigo
$tipoViaje=$_GET['tipoViaje'];



$sql = "INSERT INTO `agencia_viajes`.`destino`
(`DESTINO_LUG`,
`DESTINO_DIR`,
`DESTINO_CIU`,
`DESTINO_PAI`,
`DESTINO_FK_TI_V`)
VALUES
('$lugar',
'$direccion',
'$ciudad',
'$pais',
'$tipoViaje')";

$resultado = mysqli_query($conexion, $sql);

$data = [
  "estado" => $resultado
];
if ($resultado){
    $sql = "SELECT  DESTINO_COD, DESTINO_LUG,DESTINO_CIU, DESTINO_DIR, 
                    DESTINO_PAI, TIPO_VIAJE_TIP AS 'DESTINO_FK_TI_V', TIPO_VIAJE_PRE 
            FROM DESTINO 
            INNER JOIN TIPO_VIAJE ON TIPO_VIAJE_COD= DESTINO_FK_TI_V 
            WHERE (DESTINO_LUG LIKE '$lugar'  AND  DESTINO_CIU 
            LIKE '$ciudad') AND TIPO_VIAJE_COD LIKE '$tipoViaje'";
   $stm = mysqli_query($conexion, $sql);
   $resultSet = mysqli_fetch_assoc($stm);
   $data["objeto"] = json_encode($resultSet);
  
  }
  mysqli_close($conexion);
  echo json_encode($data);

