<?php
include_once('locales.php');
$locales = new locales();
if(isset($_POST['ciudad'])){
	echo $locales->getJSONLocalesCiudad($_POST['ciudad']);
} else {
	echo $locales->getJSONError('envio','Error en el envío de datos');
}
?>