<html>
	<head>
		<title>
			Editar coche
		</title>
		<script>
			function calcParentHeight()
			{
				//find the height of the internal page
				var the_body = document.getElementsByTagName('body');
				var the_height=400;
				//the_body[0].scrollHeight=400;
				//alert(the_height);
				//change the height of the iframe
				parent.document.getElementById('the_iframe').height=
				the_height;
			}
		</script>
	</head>
	<!--<body onload="parent.calcHeight();">-->
	<body onload="calcParentHeight();">
		<form name="miform" action="./editar2.php">
			<?php
			$id       = $_GET['id'];
			$conexion = new PDO("mysql:host=localhost;dbname=pruebas","root","");
			$consulta = "SELECT * FROM juegos WHERE id=".$id;
			$resultado= $conexion->query($consulta);
			$generos  = Array("Arcade","Aventura","Estrategia","L&oacute;gica","Plataformas","Puzzle","Rol");
			foreach($resultado as $fila)
			{
			echo("ID:<input type=\"text\" size=\"2\" name=\"id\" value=\"".$fila[0]."\" readonly></input><br />");
			echo("NOMBRE:<input type=\"text\" size=\"16\" name=\"nombre\" value=\"".$fila[1]."\"></input><br />");
			echo("CATEGORIA:<select name=\"genero\">");
			for($i = 0;$i < sizeOf($generos);$i++)
			{
				if($generos[$i] == $fila[2])
				{
					echo("<option selected=\"selected\">".$generos[$i]."</option>");
				}
				else
				{
					echo("<option>".$generos[$i]."</option>");
				}
			}
			echo("</select><br/>");

			
			try
			{
				$files = glob('../img/*.*');
				echo "Imagen: <select name=\"imagen\">";
				foreach($files as $file){
					$path_img = "img/".pathinfo($file, PATHINFO_BASENAME);
					
					if($path_img==$fila[3]) {
						echo "<option selected=\"selected\" value=\"img/".pathinfo($file, PATHINFO_BASENAME)."\">".pathinfo($file, PATHINFO_BASENAME)."</option>";
					} else {
						//echo "<option value=\"img/".pathinfo($file, PATHINFO_BASENAME)."\">".pathinfo($file, PATHINFO_BASENAME)."</option>";
						echo "<option value=\"img/".pathinfo($file, PATHINFO_BASENAME)."\">".pathinfo($file, PATHINFO_BASENAME)."</option>";
					}
				}
				echo "</select><br />";
			} catch(Exception $e){
			}
			
			try
			{
				$files = glob('../img/thumb/*.*');
				echo "Miniatura: <select name=\"mini\">";
				foreach($files as $file){
					$path_img = "img/thumb/".pathinfo($file, PATHINFO_BASENAME);
					
					if($path_img==$fila[4]) {
						echo "<option selected=\"selected\" value=\"img/thumb/".pathinfo($file, PATHINFO_BASENAME)."\">".pathinfo($file, PATHINFO_BASENAME)."</option>";
					} else {
						echo "<option value=\"img/thumb/".pathinfo($file, PATHINFO_BASENAME)."\">".pathinfo($file, PATHINFO_BASENAME)."</option>";
					}
					
				}
				echo "</select><br />";
			} catch(Exception $e){
			}
			
			echo("URL:
			<input type=\"text\" size=\"16\" name=\"enlace\" value=\"".$fila[6]."\">
			</input><br />");
			$txtDesc = $fila[5];
			echo("DESCRIPCION:<br /><textarea name=\"descrip\" rows=\"4\" cols=\"50\">".ltrim($txtDesc)."</textarea><br />");
			echo("AYUDA:<br /><textarea name=\"ayuda\" rows=\"4\" cols=\"50\">".ltrim($fila[8])."</textarea><br />");
			echo("TIPO:<select name=\"tipo\">");
			$tipos = Array("FUSION","JSGB","PHASER","NESBOX","UNITY");
			for($i=0;$i<sizeOf($tipos);$i++) {
			if($tipos[$i]==$fila[9]) {
			echo("
			<option selected=\"selected\">
				".$tipos[$i]."
			</option>");
			} else {
			echo("
			<option>
				".$tipos[$i]."
			</option>");
			}		
			}
			echo("</select><br />");
			echo("ACTIVO:
			<input
				name=\"activo\" type=\"checkbox\"");
				if($fila[7]==1) {
				echo(" checked>
			</input><br />");
			} else {
			echo("></input><br />");
			}
			echo("PUNTUACIONES:
			<input
				name=\"puntuaciones\" type=\"checkbox\"");
				if($fila[10]==1) {
				echo(" checked>
			</input><br />");
			} else {
			echo("></input><br />");
			}
			echo("LOGROS:
			<input
				name=\"logros\" type=\"checkbox\"");
				if($fila[11]==1) {
				echo(" checked>
			</input><br />");
			} else {
			echo("></input><br />");
			}
			}
			?>
			<button type="submit" style="float:left;">
				Actualizar
			</button>
			<input type="button" onclick="window.history.back();" value="Volver" style="float:left;">
			</input>
		</form>
	</body>
</html>