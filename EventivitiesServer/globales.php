<?php
class config{
	public static function getBBDDServer() {
		return 'sql103.eshost.es';
	}

	public static function getBBDDName(){
		return  'eshos_12005881_EventivitiesADM';
	}

	public static function getBBDDUser(){
		return 'eshos_12005881';
	}

	public static function getBBDDPwd(){
		return 'proyecto';
	}
}




// function conectarConBD(){
// $servidor = "sql103.eshost.es";
// $usuario = "eshos_12005881";
// $pass = "proyecto";
// $nombreBD = "eshos_12005881_EventivitiesADM";*/

// // Conecta con el servidor
// if (!($link = mysql_connect($servidor, $usuario, $pass))) {
// 	echo 'Error conectando con el servidor. <br>';
// 	exit();
// }
// // Selecciona la BD del servidor
// if (!mysql_select_db($nombreBD, $link)) {
// 	echo 'Error seleccionando la base de datos. <br>';
// 	exit();
// }
// return $link;
// }

// Desde cualquier php:
//<?php //    $link = conectarConBD(); >

?>
