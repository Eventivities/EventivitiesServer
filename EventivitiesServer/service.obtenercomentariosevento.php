<?php
include_once('comentarios.php');
$comentarios = new comentarios();
if(isset($_POST['idEvento'])){
	echo $comentarios->getJSONComentariosEvento($_POST['idEvento']);
} else {
	echo $comentarios->getJSONError('envio','Error en el envío de datos');
}
?>