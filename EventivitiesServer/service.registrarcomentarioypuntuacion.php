<?php
include_once('comentarios.php');
$comentarios = new comentarios();
//echo $comentarios->getJSONComentarioYPuntuacion(1, 'comentypuntu1', 3, 10);
if(isset($_POST['idUsuario']) and (isset($_POST['comentario']))and (isset($_POST['puntuacion']))and (isset($_POST['idEvento']))){
	$idUsuario = $_POST['idUsuario'];
	$comentario = $_POST['comentario'];
	$puntuacion=$_POST['puntuacion'];
	$idEvento=$_POST['idEvento'];
	echo $comentarios->getJSONComentarioYPuntuacion($idUsuario, $comentario, $puntuacion, $idEvento);
}
else{
	echo $comentarios->getJSONError('envio','Error en el envío de datos');
}

?>