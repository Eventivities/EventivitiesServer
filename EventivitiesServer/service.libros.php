<?php
include_once('libros.php');

$libros = new libros();
echo $libros->getJSONLibros();
?>