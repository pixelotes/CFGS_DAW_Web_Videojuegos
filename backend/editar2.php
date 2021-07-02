<?php
try {
	$id = $_GET['id'];
	$nombre = $_GET['nombre'];
	$genero = $_GET['genero'];
	$imagen = $_GET['imagen'];
	$descrip = $_GET['descrip'];
	$ayuda = $_GET['ayuda'];
	$miniatura = $_GET['mini'];
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
	$consulta = "UPDATE juegos SET nombre = '$nombre', categoria = '$genero', imagen ='$imagen', miniatura = '$miniatura', descripcion = '$descrip', ayuda = '$ayuda', url ='$enlace' , tipo = '$tipo', activo ='$activo', puntuaciones = '$puntuaciones', logros = '$logros'  WHERE id=$id;";
	$conexion->query($consulta);

	$conexion = null;

	//redirige a la página principal
	header("Location: http://localhost/prj/backend/principal.php");


} catch(PDOException $e) {
	$e->getMessage();
}