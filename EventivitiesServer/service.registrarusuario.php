<?php
include_once('usuarios.php');
$usuario = new usuario();


//echo $usuario->getJSONRegistro('1', '1');
if(isset($_POST['username']) and (isset($_POST['password']))){
	$alias = $_POST['username'];
	$clave = $_POST['password'];
	echo $login->getJSONRegistro($alias, $clave);
}
else{
	echo $login->getJSONError('envio','Error en el envío de datos');
}
?>