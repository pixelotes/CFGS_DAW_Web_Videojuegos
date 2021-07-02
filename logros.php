<?php include("funciones.php"); ?>	
<?php
if(isset($_REQUEST["idusuario"]) && isset($_REQUEST["idjuego"])){
	if(isset($_REQUEST["guardar"]) && isset($_REQUEST["idlogro"])) { //se pide guardar un logro
		if(isset($_SESSION["usuario"])) { //comprueba que el usuario que intenta guardar es el usuario con sesion activa
			//busca si el jugador tiene el logro
			//si no lo tiene
			//guarda el logro
			//guardaLogros($_REQUEST["idusuario"],$_REQUEST["idjuego"],$_REQUEST["idlogro"],$_REQUEST["nombrelogro"],$_REQUEST["tipologro"]);
			guardaLogros($_REQUEST["idjuego"], $_REQUEST["idusuario"], $_REQUEST["idlogro"], $_REQUEST["nombrelogro"], $_REQUEST["tipologro"]);
		}
	} else if(isset($_REQUEST["cargar"])) { //se pide cargar la lista de logros
	
	}
}