<?php
include_once('eventos.php');
echo 'hola';
$eventos = new eventos();
echo $eventos->getJSONEventos();
?>