<?php
include_once('locales.php');
$locales = new locales();
//echo $locales->getJSONLocalesCiudad('Valencia');
if(isset($_POST['ciudad'])){
	echo $locales->getJSONLocalesCiudad($_POST['ciudad'], $_POST['categoria']);
} else {
	echo $locales->getJSONError('envio','Error en el envío de datos');
}
?>