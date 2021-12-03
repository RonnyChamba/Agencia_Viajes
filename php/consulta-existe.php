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
    }

    $stm = mysqli_query($conexion,$sql);
    
    $resultSet = mysqli_fetch_assoc($stm);
    echo json_encode($resultSet);
  }catch(Exception $error){
    echo "Eror jeje:".$error->getMessage();
  }

?>