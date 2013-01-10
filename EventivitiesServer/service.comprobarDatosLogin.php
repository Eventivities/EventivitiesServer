<?php
include_once('usuarios.php');
$login = new usuario();

//echo $login->getJSONLogin('al', 'pal');
if(isset($_POST['username']) and (isset($_POST['password']))){
	$user = $_POST['username'];
	$pass = $_POST['password'];
	echo $login->getJSONLogin($user, $pass);
}
else{
	echo $login->getJSONError('envio','Error en el envío de datos');
}
?>