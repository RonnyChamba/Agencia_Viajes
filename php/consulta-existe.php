<?php
  include('../conexion.php');
  try{

    $sql ="";
    $tabla =$_GET['tabla'];
    $filtro =$_GET['filtro'];

    if ($tabla=="empleados") {
      $sql ="SELECT * FROM EMPLEADOS WHERE EMPLEADOS_CED LIKE '$filtro'";
    }else if ($tabla=="clientes"){
      $sql ="SELECT * FROM CLIENTES WHERE CLIENTES_CED LIKE '$filtro'"; 
    }else if ($tabla=="tipo-transporte"){
      $sql ="SELECT * FROM TIPO_TRANSPORTE WHERE TIPO_TRANSPORTE_NOM LIKE '$filtro'"; 
    }else if ($tabla=="conductor"){
      $sql ="SELECT * FROM CONDUCTOR WHERE CONDUCTOR_CED LIKE '$filtro'"; 
    }else if ($tabla=="tipo-viaje"){
      $sql ="SELECT * FROM TIPO_VIAJE WHERE TIPO_VIAJE_TIP LIKE '$filtro'"; 
    }else if ($tabla=="licencia"){
      // Cuando se invoque para esta if, se pasa el paremtro licencia
      $tipoLicencia = $_GET['licencia'];
      $sql ="SELECT CONDUCTOR_NOM, CONDUCTOR_APE,
                    LICENCIA_TIP, LICENCIA_FE_I, LICENCIA_FE_F 
            FROM CONDUCTOR 
            INNER JOIN LICENCIA ON LICENCIA_FK_CON= CONDUCTOR_CED 
            WHERE CONDUCTOR_CED  LIKE '$filtro' AND LICENCIA_TIP  LIKE '$tipoLicencia'"; 
    }else if ($tabla=="transporte"){
      $sql ="SELECT * FROM TRANSPORTE WHERE TRANSPORTE_MAT LIKE '$filtro'"; 
    }else if ($tabla=="destino"){
      $ciudad =$_GET['ciudad'];
      $tipoViaje =$_GET['tipoViaje'];
      $sql ="SELECT DESTINO_LUG,DESTINO_CIU, TIPO_VIAJE_TIP 
                    AS 'DESTINO_FK_TI_V' 
             FROM DESTINO 
             INNER JOIN TIPO_VIAJE ON TIPO_VIAJE_COD= DESTINO_FK_TI_V 
             WHERE (DESTINO_LUG LIKE '$filtro'  AND  DESTINO_CIU 
             LIKE '$ciudad') AND TIPO_VIAJE_COD LIKE '$tipoViaje'"; 
    }

    $stm = mysqli_query($conexion,$sql);
    
    $resultSet = mysqli_fetch_assoc($stm);
    echo json_encode($resultSet);
  }catch(Exception $error){
    echo "Eror jeje:".$error->getMessage();
  }

?>