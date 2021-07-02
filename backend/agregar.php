<!DOCTYPE html>
<html>
	<head>
		<title>
			Agregar nuevo juego
		</title>
		<script type="text/javascript" src="jquery.min.js">
		</script>
		<script type="text/javascript" src="dropzone.js">
		</script>
	</head>
	<body>
		<form id="agregar" action="agregar2.php">
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
						Imagen:
					</td>
					<td>
						<?php
						try {
							$files = glob('../img/*.*');
							echo "<select name=\"imagen\">";
							foreach($files as $file){
								echo "<option value=\"".pathinfo($file, PATHINFO_BASENAME)."\">".pathinfo($file, PATHINFO_BASENAME)."</option>";
							}
							echo "</select>";
						} catch(Exception $e){}
						?>
					</td>
				</tr>
				<tr>
					<td>
						Miniatura:
					</td>
					<td>
						<!--<input type="text" size="30" name="miniatura" id="miniatura"></input>-->
						<?php
						try
						{
							$files = glob('../img/thumb/*.*');
							echo "<select name=\"mini\">";
							foreach($files as $file)
							{
								echo "<option value=\"".pathinfo($file, PATHINFO_BASENAME)."\">".pathinfo($file, PATHINFO_BASENAME)."</option>";
							}
							echo "</select>";
						} catch(Exception $e)
						{
						}
						?>
						<!--<input type="file" name="datafile" size="40" name="miniatura"></input>-->
					</td>
				</tr>
				<tr>
					<td>
						URL:
					</td>
					<td>
						<input type="text" size="30" name="enlace">
						</input>
					</td>
				</tr>
				<tr>
					<td>
						Descripci&oacute;n:
					</td>
					<td>
						<textarea name="descrip" rows="4" cols="50"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						Ayuda:
					</td>
					<td>
						<textarea name="ayuda" rows="4" cols="50"></textarea>
					</td>
				</tr>
				<td>
					Tipo:
				</td>
				<td>
					<select name="tipo">
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
						Puntuaciones:
					</td>
					<td>
						<input type="checkbox" name="puntuaciones" value="true">
						</input>
					</td>
				</tr>
				<tr>
					<td>
						Logros:
					</td>
					<td>
						<input type="checkbox" name="logros" value="true">
						</input>
					</td>
				</tr>
				<tr>
					<td>
						Activo:
					</td>
					<td>
						<input type="checkbox" name="activo" value="true">
						</input>
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
					</td>
				</tr>
			</table>
		</form>
		<button type="submit" onclick="document.getElementById('agregar').submit();">
			Agregar
		</button></td><td>
		<button onclick="window.history.back();">
			Volver
		</button>
	</body>
</html>

<?php
