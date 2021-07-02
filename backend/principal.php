<!DOCTYPE html>
<html>
<head>
<title>Backend juegos</title>
<link rel="stylesheet" href="jquery.dataTables.css">
<style>
	
</style>
<script src="jquery.min.js"></script>
<script src="jquery.dataTables.min.js"></script>
</head>
<body onload="function() {
			var the_height=document.body.scrollHeight;
		document.body.scrollHeight=400;

				//change the height of the iframe
		parent.document.getElementById('the_iframe').height=
				the_height;
}">
<center><h1>LISTADO DE JUEGOS</h1></center>
<hr />
<table border="1" width="80%" id="listado">
<thead><tr><td><b>Nombre</b></td><td><b>Categor&iacute;a</b></td><td><b>Imagen</b></td><td><b>URL</b></td><td></td></tr></thead><tbody>
<?php 
	try {
		$conexion = new PDO("mysql:host=localhost;dbname=pruebas","root","");
		$consulta = "SELECT * FROM juegos";
		$resultado = $conexion->query($consulta);
		
		foreach($resultado as $fila) {
			echo("<tr>");
			echo("<td>".$fila[1]."</td>");
			echo("<td>".$fila[2]."</td>");
			echo("<td><img src=\"../".$fila[3]."\" width=\"80\"></img></td>");
			echo("<td><a href=\"../".$fila[4]."\">../".$fila[4]."</a></td>");
			echo("<td><a href=\"./editar.php?id=".$fila[0]."\">Editar</a>&nbsp;<a href=\"./eliminar.php?id=".$fila[0]."\">Eliminar</a></td>");
			echo("</tr>");
			
			$conexion = null;
			$resultado = null;
		}
	} catch (PDOException $e) {
		echo($e->getMessage());
	}
?>
</tbody></table>
<br />
<form action="./agregar.php" style="float:left;"><button type="submit">Agregar</button></form>
<form action="./buscar.php" style="float:left;"><button type="submit">Buscar</button></form>
<script>
	$(function(){
		$('#listado').dataTable({
			"paging": false,
			"language": {
            "url": "Spanish.json"
        }
		});
	});
</script>
</body>
</html>
