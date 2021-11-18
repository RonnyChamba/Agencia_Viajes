<?php		
		$servidor="localhost";
		$usuario="root";
		$clave="Losmaspepas2018";
		$bdd="agencia_viajes";

		$conexion=mysqli_connect($servidor, $usuario, $clave, $bdd);
		if($conexion==false){
			echo 'ERROR DE CONEXIÓN';
		}else{
      echo "bien conexion";
    }
		
?>