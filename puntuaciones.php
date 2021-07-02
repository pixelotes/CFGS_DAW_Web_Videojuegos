<?php

	include('parametros.php');

	if(isset($_REQUEST['guardar'])){
		//if(isset($_SESSION['usuario']) && $_SESSION['usuario']!="invitado") {
			$query = "INSERT INTO puntuacion VALUES ('', ".$_REQUEST["userid"].", ".$_REQUEST["idjuego"].", ".$_REQUEST["puntuacion"].", ".$_REQUEST["dificultad"].", now());";
			if ($ppp = $cxn->prepare($query)) {
				$ppp->execute();
				$ppp->close();
				echo("ok");
			} else {
				echo("mal");
			}
		//}
	}
	
	if(isset($_REQUEST['cargar'])){
	}