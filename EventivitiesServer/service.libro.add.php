<?php
include_once('libros.php');

$libros = new libros();
if(isset($_POST['libro'])  && isset($_POST['isbn']) ){
	echo $libros->getJSONInsertLibros($_POST['libro'], $_POST['isbn']);
} else {
	echo $libros->getJSONError('insert','Error en el envío de datos');	
}
?>
