<?php
 include('../../conexion.php');
$matricula = strtoupper($_GET['matricula']);
$color = strtoupper($_GET['color']);
$agnioFabricacion = $_GET['agnioFabricacion'];
$tipoTransporte = $_GET['tipoTransporte']; // codigo
$conductor = $_GET['conductor']; // cedula

$sql = "INSERT INTO `agencia_viajes`.`transporte`
(`TRANSPORTE_MAT`,
`TRANSPORTE_COL`,
`TRANSPORTE_AG_F`,
`TRANSPORTE_FK_TI_T`,
`TRANSPORTE_FK_CON`)
VALUES
('$matricula',
'$color',
'$agnioFabricacion',
'$tipoTransporte',
'$conductor')";
$resultado = mysqli_query($conexion, $sql);

$data = [
  "estado" => $resultado
];
if ($resultado){
    $sql = "SELECT TRANSPORTE_COD, TRANSPORTE_MAT,TRANSPORTE_COL, TRANSPORTE_AG_F,
                   TIPO_TRANSPORTE_NOM AS 'TRANSPORTE_FK_TI_T',
                   CONCAT(CONDUCTOR_NOM, ' ', CONDUCTOR_APE) AS 'TRANSPORTE_FK_CON' 
            FROM TIPO_TRANSPORTE 
            INNER JOIN TRANSPORTE ON TRANSPORTE_FK_TI_T= TIPO_TRANSPORTE_COD 
            INNER JOIN CONDUCTOR ON TRANSPORTE_FK_CON= CONDUCTOR_CED 
            WHERE  TRANSPORTE_MAT LIKE '$matricula'";
   $stm = mysqli_query($conexion, $sql);
   $resultSet = mysqli_fetch_assoc($stm);
   $data["objeto"] = json_encode($resultSet);
  
  }
  mysqli_close($conexion);
  echo json_encode($data);
