<?php
include_once('comentarios.php');
$comentarios = new comentarios();
//echo $comentarios->getJSONComentariosEvento('1');
if(isset($_POST['idEvento'])){
	echo utf8_encode($comentarios->getJSONComentariosEvento($_POST['idEvento']));
} else {
	echo $comentarios->getJSONError('envio','Error en el envío de datos');
}
?>