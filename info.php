<?php
	
	include('parametros.php');
	
    $respuesta;
	
	global $host, $port, $user, $password, $dbname, $cxn;

	$query = "SELECT * FROM Juegos WHERE id = ".$_POST['idjuego'];
	
	if ($cxn->real_query ($query)) {

		if ($result = $cxn->store_result()) {
			$nrows = $result->num_rows;
			
			$all_rows = $result->fetch_all(MYSQLI_ASSOC);

			$respuesta = $all_rows[0]['nombre']."||".$all_rows[0]['categoria']."||".$all_rows[0]['imagen']."||".$all_rows[0]['miniatura']."||".$all_rows[0]['descripcion']."||".$all_rows[0]['url'];
		}

		$result->close(); //liberamos recursos
        
        echo $respuesta;
	}    
