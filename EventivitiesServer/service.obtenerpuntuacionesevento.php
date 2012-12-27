<?php
include_once('puntuaciones.php');
$puntuaciones = new puntuaciones();
echo $puntuaciones->getJSONPuntuaciones();
/*if(isset($_POST['idEvento'])){
	echo $puntuaciones->getJSONPuntuacionesEvento($_POST['idEvento']);
} else {
	echo $puntuaciones->getJSONError('envio','Error en el envío de datos');
}*/
?>