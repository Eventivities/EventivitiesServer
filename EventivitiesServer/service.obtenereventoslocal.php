<?php
include_once('eventos.php');
$eventos = new eventos();

if(isset($_POST['idLocal'])){
	echo $eventos->getJSONEventosLocal($_POST['idLocal']);
} else {
	echo $eventos->getJSONError('envio','Error en el envío de datos');
}
?>