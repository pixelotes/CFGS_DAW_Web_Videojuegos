<!DOCTYPE html>
<head>
	<title>buscar</title>
	<link rel="stylesheet" href="jquery.dataTables.css">
<style>
	
</style>
<script src="jquery.min.js"></script>
<script src="jquery.dataTables.min.js"></script>
</head>
<body>
<?php
try {
	if(!empty($_GET['busc'])) {		
	
		$nombre = $_GET['nombre'];
		$genero = $_GET['genero'];
		$tipo = $_GET['tipo'];

		$conexion = new PDO("mysql:host=localhost;dbname=pruebas","root","");
		$consulta = "SELECT * FROM juegos WHERE nombre LIKE '%$nombre%' AND categoria LIKE '%$genero%' AND tipo LIKE '%$tipo%';";
		$resultados = $conexion->query($consulta);

		$conexion = null;

		//redirige a la página principal
		//$redir = dirname ( "http://localhost/prj/backend/buscar.php?resultados=".$resultados);
		//header ( "Location: http://localhost/prj/backend/buscar.php?resultados=".$resultados );
		//die();
		try{
			echo("<center><h1>RESULTADOS DE LA B&Uacute;SQUEDA</h1></center>");
			echo("<hr />");
			if(sizeOf($resultados)>0) {		
			echo("<table border=\"1\" width=\"80%\" id=\"listado\">");
			echo("<thead><tr><td><b>Nombre</b></td><td><b>Categor&iacute;a</b></td><td><b>Imagen</b></td><td><b>URL</b></td><td></td></tr></thead><tbody>");
			foreach($resultados as $fila) {
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
				echo("</tbody></table>");
			} else {
				echo("No se han encontrado resultados");
			}
			echo("<form action=\"./principal.php\"><button type=\"submit\">Volver</button></form>");
		} catch (Exception $e) {
		}
	}
} catch(PDOException $e) {
	$e->getMessage();
}
?>
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