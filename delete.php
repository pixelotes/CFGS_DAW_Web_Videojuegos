<?php
include("funciones.php");
//guardaComentario($_REQUEST["id"],$_SESSION["usuario"],$_REQUEST["texto"]);
if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]!="invitado"){
	if(isset($_REQUEST["id"])) {
		$id = $_REQUEST['id'];
	
		$conexion = new PDO("mysql:host=localhost;dbname=pruebas","root","");
		$consulta = "DELETE FROM comentarios WHERE id=".$id;
		$conexion->query($consulta);
		
		$conexion = null;
		
		//redirige a la página principal
		die();
	}
}
?>