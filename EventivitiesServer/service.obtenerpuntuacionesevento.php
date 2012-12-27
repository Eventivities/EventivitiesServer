<?php
include_once('puntuaciones.php');
$puntuaciones = new puntuaciones();
if(isset($_POST['idEvento'])){
	echo $puntuaciones->getJSONPuntuacionesEvento($_POST['idEvento']);
} else {
	echo $puntuaciones->getJSONError('envio','Error en el envío de datos');
}
?>