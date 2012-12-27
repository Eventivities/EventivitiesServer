<?php

        $servidor = "sql103.eshost.es";
        $usuario = "eshos_12005881";
        $pass = "proyecto";
        $nombreBD = "eshos_12005881_EventivitiesADM";

        // Conecta con el servidor
        if (!($link = mysql_connect($servidor, $usuario, $pass))) {
            echo 'Error conectando con el servidor. <br>';
            exit();
        }
        else
        {
        	echo 'Conectado con el servidor.';
        }
        // Selecciona la BD del servidor
        if (!mysql_select_db($nombreBD, $link)) {
            echo 'Error seleccionando la base de datos. <br>';
            exit();
        }
        else
        {
        	echo 'Seleccionada la bd.';
        }   
      
    
?>
