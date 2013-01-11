<?php
include_once('eventos.php');
$eventos = new eventos();
//echo $eventos->getJSONEventosLocal(1);
if(isset($_POST['idLocal'])){
	echo utf8_encode($eventos->getJSONEventosLocal($_POST['idLocal']));
} else {
	echo $eventos->getJSONError('envio','Error en el envío de datos');
}
?>