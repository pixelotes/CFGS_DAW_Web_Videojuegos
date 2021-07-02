<?php
try {
	$id = $_GET['id'];
	
	$conexion = new PDO("mysql:host=localhost;dbname=pruebas","root","");
	$consulta = "DELETE FROM juegos WHERE id=".$id;
	$conexion->query($consulta);
	
	$conexion = null;
	
	//redirige a la página principal
	header("Location: http://localhost/prj/backend/principal.php");
	die();
	
	
} catch(PDOException $e) {
	$e->getMessage();
}