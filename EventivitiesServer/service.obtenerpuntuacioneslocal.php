<?php
include_once('puntuacioneslocal.php');
$puntuacioneslocal = new puntuacioneslocal();
if(isset($_POST['idLocal'])){
	echo $puntuacioneslocal->getJSONPuntuacionesLocal($_POST['idLocal']);
} else {
	echo $puntuacioneslocal->getJSONError('envio','Error en el envío de datos');
}
?>