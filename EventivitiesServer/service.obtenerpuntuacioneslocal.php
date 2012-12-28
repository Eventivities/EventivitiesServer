<?php
include_once('puntuacioneslocal.php');
$puntuaciones = new puntuacioneslocal();
if(isset($_POST['idLocal'])){
	echo $puntuaciones->getJSONPuntuacionesLocal($_POST['idLocal']);
} else {
	echo $puntuaciones->getJSONError('envio','Error en el envío de datos');
}
?>