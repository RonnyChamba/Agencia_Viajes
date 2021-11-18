<?php		
		$servidor="localhost";
		$usuario="root";
		$clave="Losmaspepas2018";
		$bdd="agencia_viajes";

		$conexion=mysqli_connect($servidor, $usuario, $clave, $bdd);
		if(!$conexion){
			echo 'ERROR DE CONEXIÓN';
		}
		
?>