<?php
 include('../../conexion.php');
$observacion = $_GET['observacion'];
$codCompra = $_GET['codCompra'];
$subtotal = $_GET['subtotal'];
$total = $_GET['total'];

$sql = "INSERT INTO `agencia_viajes`.`factura`
(`FACTURA_OBS`,
`FACTURA_FEC`, 
`FACTURA_FK_COM`,
`FACTURA_SUB`,
`FACTURA_TOT`)
VALUES
('$observacion',
CURDATE(),
'$codCompra',
'$subtotal',
'$total')";
$resultado = mysqli_query($conexion, $sql);

$data = [
  "estado" => $resultado
];
if ($resultado){
    $sql = "SELECT  FACTURA_COD, CONCAT(EMPLEADOS_NOM,' ', EMPLEADOS_APE) AS FACTURA_EMPLEADO, 
                    CONCAT(CLIENTES_NOM,' ',CLIENTES_APE) AS FACTURA_CLIENTE, 
                    DESTINO_LUG AS FACTURA_LUG, FACTURA_FEC,  COMPRA_NU_B AS FACTURA_BOL, 
                    TIPO_VIAJE_PRE AS FACTURA_PRE, 
                    FACTURA_SUB, ((FACTURA_SUB*12)/100) AS FACTURA_IVA, FACTURA_TOT 
            FROM FACTURA
            INNER JOIN COMPRA ON COMPRA_COD = FACTURA_FK_COM 
              INNER JOIN EMPLEADOS ON EMPLEADOS_CED  = COMPRA_FK_EMP 
            INNER JOIN CLIENTES  ON CLIENTES_CED = COMPRA_FK_CLI 
            INNER JOIN DESTINO ON   DESTINO_COD = COMPRA_FK_DES 
            INNER JOIN TIPO_VIAJE ON TIPO_VIAJE_COD = DESTINO_FK_TI_V 
            WHERE FACTURA_COD =(SELECT  MAX(FACTURA_COD) FACTURA_COD FROM FACTURA)";


   $stm = mysqli_query($conexion, $sql);
   $resultSet = mysqli_fetch_assoc($stm);
   $data["objeto"] = json_encode($resultSet);
  
  }
  mysqli_close($conexion);
  echo json_encode($data);

