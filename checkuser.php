<?php
include("funciones.php");
	if(isset($_REQUEST["nombre"])) {
		global $host, $port, $user, $password, $dbname;

		$cxn = new mysqli($host, $user, $password, $dbname, $port)
		or die ('Ocurrió un error al conectar con la base de datos.' . mysqli_connect_error());

		$query = "SELECT * FROM usuarios WHERE usuario='".$_REQUEST["nombre"]."';";
		//Realiza la consulta
		if($result = mysqli_query($cxn,$query))
		{
			if(mysqli_num_rows($result) > 0){
				
				echo("Ya existe un usuario con ese nombre");

			}
			else
			{
				echo("");
			}
			mysqli_free_result($result);
		}

		mysqli_close($cxn);
	}
?>