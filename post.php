<?php
include("funciones.php");
if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]!="invitado"){
	if(isset($_REQUEST["get"])) {
		generaComentarios($_REQUEST["id"]);
	} else {
		$texto = $_REQUEST["texto"];
		guardaComentario($_REQUEST["id"],$_SESSION["usuario"],$_REQUEST["texto"]);
	}
}
?>