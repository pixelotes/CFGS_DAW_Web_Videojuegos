<?php
	$host     = "p:localhost";
	$port     = 3306;
	$user     = "root";
	$password = "";
	$dbname   = "pruebas";
	$cxn      = new mysqli($host, $user, $password, $dbname, $port) or die ('Ocurrió un error al conectar con la base de datos.' . mysqli_connect_error());
?>