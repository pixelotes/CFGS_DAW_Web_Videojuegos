<!DOCTYPE html>
<html>
<head>
<title>Buscar juego</title>
</head>
<body>
<center><h1>BUSCAR</h1></center>
<hr />
		<form id="buscar" action="buscar2.php">
			<table>
				<tr>
					<td>
						Nombre:
					</td>
					<td>
						<input type="text" size="30" name="nombre">
						</input>
					</td>
				</tr>
				<tr>
					<td>
						Categor&iacute;a:
					</td>
					<td>
						<select name="genero">
							<option></option>
							<option>
								Arcade
							</option>
							<option>
								Aventura
							</option>
							<option>
								Estrategia
							</option>
							<option>
								L&oacute;gica
							</option>
							<option>
								Plataformas
							</option>
							<option>
								Puzzle
							</option>
							<option>
								Rol
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Tipo:
					</td>
					<td>
						<select name="tipo">
							<option></option>
							<option>
								FUSION
							</option>
							<option>
								JSGB
							</option>
							<option>
								NESBOX
							</option>
							<option>
								PHASER
							</option>
							<option>
								UNITY
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
					<input type="hidden" name="busc" value="true"></input>
					</td>
					<td>
					</td>
				</tr>
			</table>
		</form>
		<button type="submit" onclick="document.getElementById('buscar').submit();">
		
			Buscar
		</button></td><td>
		
		<button onclick="window.history.back();">
			Volver
		</button>

<?php
//si la página se carga con resultados se renderiza una tabla
try{
	if(!empty($_GET['resultados'])) {		
		$resultados = $_GET['resultados'];
		echo("<table border=\"1\">");
		foreach($resultados as $fila){
			echo("<tr><td>$fila[1]</td><td>$fila[2]</td><td>$fila[3]</td>td>$fila[4]</td>td>$fila[5]</td></tr>");
		}
		echo("</table>");
	}
} catch (Exception $e) {
}
?>
</body>
</html>
