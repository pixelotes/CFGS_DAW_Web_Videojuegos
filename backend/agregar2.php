<?php
try {
	$nombre = $_GET['nombre'];
	$genero = $_GET['genero'];
	$imagen = "img/".$_GET['imagen'];
	$descrip = $_GET['descrip'];
	$ayuda = $_GET['ayuda'];
	$miniatura = "img/thumb/".$_GET['mini'];
	$enlace = $_GET['enlace'];
	$tipo = $_GET['tipo'];
	$activo;
	$puntuaciones;
	$logros;
	
	if(isset($_GET['activo'])&&($_GET['activo']==true)) {
		$activo = true;
	} else {
		$activo = false;
	}
	
	if(isset($_GET['logros'])&&($_GET['logros']==true)) {
		$logros = true;
	} else {
		$logros = false;
	}
	
	if(isset($_GET['puntuaciones'])&&($_GET['puntuaciones']==true)) {
		$puntuaciones = true;
	} else {
		$puntuaciones = false;
	}

	$conexion = new PDO("mysql:host=localhost;dbname=pruebas","root","");
	$consulta = "insert into juegos (nombre, categoria, imagen, miniatura, descripcion, url, activo, ayuda, tipo, puntuaciones, logros) values ('$nombre','$genero','$imagen', '$miniatura', '$descrip', '$enlace','$activo', '$ayuda', '$tipo', '$puntuaciones', '$logros');";
	//$consulta = "insert into juegos (nombre, categoria, imagen, url) values ('$nombre','$genero','$imagen','$enlace');";
	$conexion->query($consulta);

	$conexion = null;

	//redirige a la página principal
	header("Location: http://localhost/prj/backend/principal.php");


} catch(PDOException $e) {
	$e->getMessage();
}