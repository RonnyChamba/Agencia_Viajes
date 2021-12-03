<?php
 include('../../conexion.php');

 $nombre = strtoupper($_GET['nombre']);
$fechaExpedicion= $_GET['fechaExpedicion'];
$fechaExpiracion= $_GET['fechaExpiracion'];
$conductor= $_GET['conductor'];

$sql = "INSERT INTO `agencia_viajes`.`licencia`
(`LICENCIA_TIP`,
`LICENCIA_FE_I`,
`LICENCIA_FE_F`,
`LICENCIA_FK_CON`)
VALUES
('$nombre',
'$fechaExpedicion',
'$fechaExpiracion',
'$conductor')";
$resultado = mysqli_query($conexion, $sql);

$data = [
  "estado" => $resultado
];
if ($resultado){
    $sql = "SELECT LICENCIA_COD, LICENCIA_TIP, LICENCIA_FE_I, LICENCIA_FE_F,
                   CONCAT(CONDUCTOR_NOM,' ' ,CONDUCTOR_APE) AS 'LICENCIA_FK_CON' 
            FROM CONDUCTOR 
            INNER JOIN LICENCIA ON LICENCIA_FK_CON= CONDUCTOR_CED 
            WHERE CONDUCTOR_CED  LIKE '$conductor' AND LICENCIA_TIP LIKE '$nombre'";
   $stm = mysqli_query($conexion, $sql);
   $resultSet = mysqli_fetch_assoc($stm);
   $data["objeto"] = json_encode($resultSet);
  
  }
  mysqli_close($conexion);
  echo json_encode($data);

