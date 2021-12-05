<?php
  include('../conexion.php');
  try{

    $tabla =$_GET['tabla'];
    $sql ="SELECT * FROM  {$tabla}";
    if ($tabla =="TRANSPORTE") {
       $sql = "SELECT TRANSPORTE_COD, TRANSPORTE_MAT,TRANSPORTE_COL, TRANSPORTE_AG_F,
                   TIPO_TRANSPORTE_NOM AS 'TRANSPORTE_FK_TI_T',
                   CONCAT(CONDUCTOR_NOM, ' ', CONDUCTOR_APE) AS 'TRANSPORTE_FK_CON' 
            FROM TIPO_TRANSPORTE 
            INNER JOIN TRANSPORTE ON TRANSPORTE_FK_TI_T= TIPO_TRANSPORTE_COD 
            INNER JOIN CONDUCTOR ON TRANSPORTE_FK_CON= CONDUCTOR_CED";
    }else if($tabla =="DESTINO"){
      $sql ="SELECT DESTINO_COD, DESTINO_LUG, DESTINO_DIR, DESTINO_CIU, DESTINO_PAI, 
                    TIPO_VIAJE_TIP AS 'DESTINO_FK_TI_V', TIPO_VIAJE_PRE 
             FROM DESTINO 
            INNER JOIN TIPO_VIAJE ON TIPO_VIAJE_COD =DESTINO_FK_TI_V";
    }
    $data = [];
    if ( $resultado=mysqli_query($conexion,$sql)){
        while ( $resultSet = mysqli_fetch_assoc($resultado)) {
        array_push($data, $resultSet);
      }
     }
     echo  json_encode ($data);
  }catch(Exception $error){ 
    echo "Eror jeje:".$error->getMessage();
  }

?>