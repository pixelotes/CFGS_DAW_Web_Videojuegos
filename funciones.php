<?php

include('parametros.php');
session_set_cookie_params(7200,"/");
session_start(); //para manipular variables de sesiÃ³n SIEMPRE hay que poner session_start();
try
{
	//session_regenerate_id(true);
} catch(Exception $e){

}

function recuperaPass($correo)
{

	global $host, $port, $user, $password, $dbname;

	$subject = 'Contraseña perdida';
	$headers = 'From: webmaster@noentiendo.es' . "\r\n" .
	'Reply-To: webmaster@noentiendo.es' . "\r\n" .
	'X-Mailer: PHP/' . phpversion();

	$con     = mysqli_connect($host,$user,$password,$dbname);
	// Comprueba la conexión
	if(mysqli_connect_errno()){
		echo "Fallo en la conexión con MySQL: " . mysqli_connect_error();
	}
	$sql = "SELECT * FROM usuarios WHERE correo = '".$correo."' LIMIT 1;";

	//Realiza la consulta
	if($result = mysqli_query($con,$sql))
	{
		if(sizeof($result) > 0){
			//En caso de encontrar recultados
			$row     = mysqli_fetch_row($result);
			$message = 'Su cuenta de usuario es '.$row[1].' y su contraseña es '.$row[2];
			mail($correo, $subject, $message, $headers); //envia correo de confirmación
		}
		else
		{
			//En caso de no encontrarlos
			$message = 'No se ha encontrado ninguna cuenta registrada con esta dirección de correo';
			mail($correo, $subject, $message, $headers); //envia correo de denegación
		}
		mysqli_free_result($result);
	}

	mysqli_close($con);
}

function generaBotones()
{
	if(isset($_SESSION["usuario"]) && $_SESSION["usuario"] != null && $_SESSION["usuario"] != 'admin'){
		echo("<button type=\"submit\" id=\"btnDesconectar\">Desconectar</button>");
	}
	else
	if(isset($_SESSION["usuario"]) && $_SESSION["usuario"] == 'admin'){
		echo("<button type=\"submit\" id=\"btnAdministrar\" style=\"margin-right: 5px;\">Administrar</button>");
		echo("<button type=\"submit\" id=\"btnDesconectar\">Desconectar</button>");
	}
	else
	{
		echo("<button id=\"btnMenuRegistro\" style=\"margin-right: 5px;\"title=\"&iquest;No tienes cuenta? Pues rellena este formulario. &iexcl;Es r&aacute;pido!\">Registro</button>");
		echo("<button id=\"btnMenuLogin\">Login</button>");
	}
}

function generaBotones2()
{


	if(isset($_SESSION["usuario"]) && $_SESSION["usuario"] != null && $_SESSION["usuario"] != 'admin'){
		echo("<div id=\"header\">");
		echo("<ul class=\"nav\">");
		echo("<li><a href=\"\"><img src=\"img/web/menu.png\" width=\"28\" height=\"28\"></img></a>");
		echo("<ul>");
		echo("<li><a href=\"index.php\">Principal</a></li>");
		echo("<li><a href=\"user.php?user=".$_SESSION['usuario']."\">Estad&iacute;sticas</a></li>");
		echo("<li><a href=\"desconectar.php\">Desconectar</a></li>");
		echo("</ul>");
		echo("</li>");
		echo("</ul>");
		echo("</div>");
	}
	else
	if(isset($_SESSION["usuario"]) && $_SESSION["usuario"] == 'admin'){
		echo("<div id=\"header\">");
		echo("<ul class=\"nav\">");
		echo("<li><a href=\"\"><img src=\"img/web/menu.png\" width=\"28\" height=\"28\"></img></a>");
		echo("<ul>");
		echo("<li><a href=\"index.php\">Principal</a></li>");
		echo("<li><a href=\"user.php?user=".$_SESSION['usuario']."\">Estad&iacute;sticas</a></li>");
		echo("<li><a href=\"administrar.php\">Backend</a></li>");
		echo("<li><a href=\"//localhost/adminer\" target=\"_blank\">Adminer</a></li>");
		echo("<li><a href=\"extplorer\" target=\"_blank\">Extplorer</a></li>");
		echo("<li><a href=\"desconectar.php\">Desconectar</a></li>");
		echo("</ul>");
		echo("</li>");
		echo("</ul>");
		echo("</div>");;
	}
	else
	{
		echo("<button id=\"btnMenuRegistro\" style=\"margin-right: 5px;\"title=\"&iquest;No tienes cuenta? Pues rellena este formulario. &iexcl;Es r&aacute;pido!\">Registro</button>");
		echo("<button id=\"btnMenuLogin\">Login</button>");
	}
}

//registra un nuevo usuario, devuelve true si se realiza con éxito y false si no
function registraUsuario($usu,$pass,$mail)
{

	global $host, $port, $user, $password, $dbname, $cxn;

	$query = "INSERT INTO usuarios VALUES ('','".$usu."','".$pass."','".$mail."');";
	if($ppp = $cxn->prepare($query)){
		$ppp->execute();
		$ppp->close();
		return true;
	}
	else
	{
		return false;
	}
}

function guardaEstadisticasAcceso($usu,$juego)
{

	global $host, $port, $user, $password, $dbname;

	$cxn = new mysqli($host, $user, $password, $dbname, $port)
	or die ('Ocurrió un error al conectar con la base de datos.' . mysqli_connect_error());

	$query = "INSERT INTO accesos VALUES ('', (SELECT id FROM usuarios WHERE usuario = '".$usu."' LIMIT 1), ".$juego.", now());";
	if($ppp = $cxn->prepare($query)){
		$ppp->execute();
		$ppp->close();
		return true;
	}
	else
	{
		return false;
	}
}

function devuelveUser()
{
	if(isset($_SESSION["usuario"]) && ($_SESSION["usuario"] != ""||$_SESSION["usuario"] != 'admin')){
		echo("<a href=\"user.php?user=".$_SESSION["usuario"]."\" style=\"text-decoration: none;\">".$_SESSION["usuario"]."</a>");
	}
	else
	{
		echo("invitado");
	}
}

function checkLogin($usu,$pass)
{

	global $host, $port, $user, $password, $dbname;

	$cxn = new mysqli($host, $user, $password, $dbname, $port)
	or die ('Ocurrió un error al conectar con la base de datos.' . mysqli_connect_error());

	$query = "SELECT * FROM usuarios WHERE usuario = '".$usu."' AND password = '".$pass."';";
	if($stmt = $cxn->prepare($query)){

		/* execute query */
		$stmt->execute();

		/* store result */
		$stmt->store_result();

		$num = $stmt->num_rows;
		//echo "Resultados(".$usu.",".$pass."): ".$num;
		if($num > 0){
			$stmt->close();
			return true;
		}
		else
		{
			$stmt->close();
			return false;
		}
		/* close statement */

	}
}

function inicializa()
{
	if(empty($_SESSION['login'])){
		$_SESSION['login'] = false;
	}
	if(empty($_SESSION['usuario'])){
		$_SESSION['usuario'] = "";
	}
}

function devuelveUltimosJugados($usu,$num)
{

	global $host, $port, $user, $password, $dbname;

	$cxn = new mysqli($host, $user, $password, $dbname, $port)
	or die ('Ocurrió un error al conectar con la base de datos.' . mysqli_connect_error());

	$query = "SELECT *, (SELECT nombre from juegos WHERE juegos.id = accesos.juego) AS nombre from accesos where usuario = (SELECT id from usuarios WHERE usuario='".$usu."') order by fecha limit ".$num.";";
	$query = "SELECT *, (SELECT nombre from juegos WHERE juegos.id = accesos.juego) AS nombre from accesos where usuario = (SELECT id from usuarios WHERE usuario='".$_SESSION['usuario']."') order by id DESC limit ".$num.";";

	if(isset($usu)){
		//devuelve los 5 ultimos jugados del usuario

	}
	else
	if($usu == ""){
		$query = "SELECT *, (SELECT nombre from juegos WHERE juegos.id = accesos.juego) AS nombre from accesos order by fecha desc limit ".$num.";";
		//devuelve los 5 ultimos jugados
	}

	//Realiza la consulta
	if($result = mysqli_query($cxn,$query))
	{
		if(sizeof($result) > 0){
			//En caso de encontrar recultados
			echo ("<ul style=\"margin: 0; padding: 0;\">");
			while($row = mysqli_fetch_row($result)){
				echo("<li style=\"display:block; float:left; margin: 0; color: white; border: 1px solid #d00a0a; background-color: #d00a0a; font-weight: bold; border-radius: 3px; margin: 3px; padding: 3px;\"><a style=\"text-decoration: none; color: white;\" href=\"game.php?id=".$row[2]."\" title=\"".$row[3]."\">".$row[4]."</a></li>");
			}
			echo ("</ul><div style=\"clear:both;\"></div>");
		}
		else
		{
			//En caso de no encontrarlos
			echo("Todav&iacute;a no has jugado a ning&uacute;n juego.");
		}
		mysqli_free_result($result);
	}

	mysqli_close($cxn);
}

function devuelveMasJugados($usu,$num = 5)
{

	global $host, $port, $user, $password, $dbname;

	$cxn = new mysqli($host, $user, $password, $dbname, $port)
	or die ('Ocurrió un error al conectar con la base de datos.' . mysqli_connect_error());

	$query = "SELECT juego,(SELECT nombre from juegos WHERE juegos.id = accesos.juego) AS nombre, count(*) AS veces, (SELECT url from juegos WHERE juegos.id = accesos.juego) as enlace from accesos where usuario = (SELECT id from usuarios WHERE usuario='".$usu."') group by juego order by veces desc limit ".$num.";";

	if(isset($usu) && $usu != ""){
		//devuelve los 5 mas jugados del usuario
	}
	else
	{
		$query = "SELECT juego,(SELECT nombre from juegos WHERE juegos.id = accesos.juego) AS nombre, count(*) AS veces from accesos group by juego order by veces desc limit ".$num.";";
	}

	//Realiza la consulta
	if($result = mysqli_query($cxn,$query))
	{
		if(sizeof($result) > 0){
			//En caso de encontrar recultados
			echo ("<ul style=\"margin: 0; padding: 0;\">");
			while($row = mysqli_fetch_row($result)){
				echo("<li style=\"display:block; float:left; margin: 0; color: white; border: 1px solid #d00a0a; background-color: #d00a0a; font-weight: bold; border-radius: 3px; margin: 3px; padding: 3px;\"><a style=\"text-decoration: none; color: white;\" href=\"game.php?id=".$row[0]."\">".$row[1]." (".$row[2].")</a></li>");
			}
			echo ("</ul><div style=\"clear:both;\"></div>");
		}
		else
		{
			//En caso de no encontrarlos
			echo("Todav&iacute;a no has jugado a ning&uacute;n juego.");
		}
		mysqli_free_result($result);
	}

	mysqli_close($cxn);
}

function devuelveLogros($usu, $idjuego = 0)
{

	global $host, $port, $user, $password, $dbname;

	$cxn = new mysqli($host, $user, $password, $dbname, $port)
	or die ('Ocurrió un error al conectar con la base de datos.' . mysqli_connect_error());

	$query = "SELECT *, (SELECT nombre from juegos WHERE juegos.id = logros.idjuego) AS njuego FROM logros where idusuario = (SELECT id from usuarios where usuario = '".$usu."') order by fecha desc;";

	if($idjuego != 0){
		//devuelve los logros del usuario para un juego
		$query = "SELECT *, (SELECT nombre from juegos WHERE juegos.id = logros.idjuego) AS njuego FROM logros where idusuario = (SELECT id from usuarios where usuario = '".$usu."') AND idjuego = ".$idjuego."order by fecha desc;";
	}

	//Realiza la consulta
	if($result = mysqli_query($cxn,$query))
	{
		if(sizeof($result) > 0){
			//En caso de encontrar recultados
			echo ("<div style=\"clear:both;\"></div><ul style=\"margin: 0; padding: 0;\">");
			$tipo;



			while($row = mysqli_fetch_row($result)){

				if($row[6] == 1){
					$tipo = "bronce";
				}
				else
				if($row[6] == 2){
					$tipo = "plata";
				}
				else
				if($row[6] == 3){
					$tipo = "oro";
				}

				echo ("<li class=\"medal\" style=\"list-style:none;display:inline-block;margin: 15px;\" title=\"".$row[4]." (".$row[7].")\">");
				echo ("<a href=\"game.php?id=".$row[2]."\"><img style=\"height: 128px;\" src=\"img/medal/".$tipo.".png\"></img></a>");
				echo ("</li>");

			}
			echo ("</ul><div style=\"clear:both;\"></div>");
			echo ("<script>$(function(){
				$(\".medal\").tooltip();
				});</script>");
		}
		else
		{
			//En caso de no encontrarlos
			echo("Todav&iacute;a no has jugado a ning&uacute;n juego.");
		}
		mysqli_free_result($result);
	}

}

function guardaLogros($j,$u,$l,$n,$t)
{

	global $host, $port, $user, $password, $dbname;

	$cxn = new mysqli($host, $user, $password, $dbname, $port)
	or die ('Ocurrió un error al conectar con la base de datos.' . mysqli_connect_error());

	//Si no ha encontrado el logro para el juego y el usuario, lo guarda. En caso contrario lo ignora.
	$query = "SELECT * FROM logros WHERE idusuario=".$u." AND idjuego=".$j." AND idlogro=".$l." ;";
	if($result = mysqli_query($cxn,$query)){
		if(mysqli_num_rows($result) == 0){
			$result->close();
			$query = "INSERT INTO logros VALUES ('', ".$u.", ".$j.", ".$l.", '".$n."', now(), ".$t.");";
			if($ppp = $cxn->prepare($query)){
				$ppp->execute();
				$ppp->close();

				echo("LOGRO: ".$n);
				return true;
			}
			else
			{
				echo("X");
				return true;
			}
			;
		}
		else
		{
			echo("X");
			return true;
		}

	}
}

function devuelveComentarios($usu, $idjuego = 0, $ultimos = 5)
{

	global $host, $port, $user, $password, $dbname;

	$cxn = new mysqli($host, $user, $password, $dbname, $port)
	or die ('Ocurrió un error al conectar con la base de datos.' . mysqli_connect_error());

	$query = "SELECT *, (SELECT nombre from juegos WHERE juegos.id = comentarios.idjuego) AS nombre FROM comentarios WHERE idjuego = ".$idjuego." order by id desc";
	if(!isset($usu) && isset($ultimos)){
		$query = $query." LIMIT ".$ultimos;
	}
	if(isset($idjuego) && !isset($ultimos)){
		$query = "SELECT *, (SELECT nombre from juegos WHERE juegos.id = comentarios.idjuego) AS nombre FROM comentarios WHERE idusuario = (SELECT id from usuarios where usuario = 'admin') order by id desc";
	}

	if($idjuego != 0){
		$query = "SELECT *, (SELECT nombre from juegos WHERE juegos.id = comentarios.idjuego) AS nombre FROM comentarios WHERE idusuario = (SELECT id from usuarios where usuario = 'admin') AND idjuego = ".$idjuego." order by id desc";
	}
	//debug
	$query = "SELECT *, (SELECT nombre from juegos WHERE juegos.id = comentarios.idjuego) AS nombre FROM comentarios WHERE idusuario = (SELECT id from usuarios where usuario = '".$usu."') order by id desc;";
	//Realiza la consulta
	if($result = mysqli_query($cxn,$query))
	{
		if(sizeof($result) > 0){
			//En caso de encontrar recultados
			echo ("<ul style=\"margin: 0; padding: 0;\">");
			$cnt = 0;
			while($row = mysqli_fetch_row($result)){
				$texto = $row[2];
				if($cnt < 5){
					if(strlen($texto) > 60){
						$texto = substr($texto,0,56);$texto = $texto."...";
					};
					echo("<li style=\"display:block; width: 100%; float:left; margin: 0; color: white; border: 1px solid #d00a0a; background-color: #d00a0a; font-weight: bold; border-radius: 3px; margin: 3px; padding: 3px;\"><a style=\"text-decoration: none; color: white;\" href=\"game.php?id=".$row[4]."\">".$row[6]."</a><span style=\"float:right;\">".$row[3]."</span><br><span style=\"color:black;background-color:white; padding-left: 5px; padding-right: 5px; margin-left: 0px; display: block;\">".$texto."</span></li>");
				}
				$cnt += 1;
			}
			echo ("</ul><div style=\"clear:both;\"></div>");

		}
		else
		{
			//En caso de no encontrarlos
			echo("Todav&iacute;a no has jugado a ning&uacute;n juego.");
		}
		mysqli_free_result($result);
	}

	mysqli_close($cxn);
}

//genera los comentarios del juego
function generaComentarios($jue)
{

	global $host, $port, $user, $password, $dbname;

	$cxn = new mysqli($host, $user, $password, $dbname, $port)
	or die ('Ocurrió un error al conectar con la base de datos.' . mysqli_connect_error());

	$query = "SELECT *, (SELECT usuario FROM usuarios WHERE usuarios.id = comentarios.idusuario) FROM comentarios WHERE idjuego = ".$jue." ORDER BY id DESC";

	//Realiza la consulta
	if($result = mysqli_query($cxn,$query))
	{
		if(mysqli_num_rows($result) > 0){
			//En caso de encontrar recultados
			echo ("<ul style=\"margin: 0; padding: 0;\">");
			echo ("<span id=\"commentHeader\">Comentarios (".mysqli_num_rows($result).")</span><span id=\"commentToggle\" onclick=\"muestraComentarios()\">ver</span>");
			if(isset($_SESSION['usuario']) && $_SESSION['usuario'] != "invitado"){
				echo ("<span id=\"commentAdd\" onclick=\"agregaComentario('".$_SESSION['usuario']."')\">agregar</span>");
			}
			echo ("<div id=\"commentBox\">");
			while($row = mysqli_fetch_row($result)){
				echo ("<div id=\"comment\">");
				if(isset($_SESSION['usuario']) && $_SESSION['usuario'] == "admin"){
					echo("<span id=\"commentDelete\" style=\"color:white;font-weight:bolder;\"><a onclick=\"eliminaComentario(".$row[0].");\">&nbsp;[X]</a></span>");
				}
				echo ("<span id=\"commentTitle\">".$row[6]."</span>");
				echo ("<span id=\"commentAuthor\">".$row[3]."</span>");
				echo ("<span id=\"commentBody\">".$row[2]."</span>");
				//Si el usuario es admin crea un icono de eliminar

				echo ("<div>");
			}
			echo ("</div>");
			echo ("</ul><div style=\"clear:both;\"></div><br><br>");
		}
		else
		{
			//En caso de no encontrarlos
			echo ("<ul style=\"margin: 0; padding: 0;\">");
			echo ("<span id=\"commentHeader\">Comentarios (0)</span>");
			if(isset($_SESSION['usuario']) && $_SESSION['usuario'] != "invitado"){
				echo ("<span id=\"commentAddNew\" onclick=\"agregaComentario('".$_SESSION['usuario']."')\">agregar</span>");
				echo("<script>$(function(muestraComentarios();){})</script>");
			}
			echo ("</ul><div style=\"clear:both;\"></div><br><br>");
		}
		mysqli_free_result($result);
	}

	mysqli_close($cxn);
}

function guardaComentario($idjuego,$usu,$mensaje)
{

	global $host, $port, $user, $password, $dbname;
	
	$cxn = new mysqli($host, $user, $password, $dbname, $port)
	or die ('Ocurrió un error al conectar con la base de datos.' . mysqli_connect_error());

	$query = "INSERT INTO comentarios VALUES ('', '', '".$mensaje."', now(), ".$idjuego.", (SELECT id FROM usuarios WHERE usuario = '".$usu."' LIMIT 1));";
	//$query = "INSERT INTO comentarios VALUES ('', '', 'olakase', now(), 6, (SELECT id FROM usuarios WHERE usuario = 'admin' LIMIT 1));";
	if($ppp = $cxn->prepare($query)){
		$ppp->execute();
		$ppp->close();
		return true;
	}
	else
	{
		return false;
	}
}

function devuelveMasJugadosAdmin()
{

	global $host, $port, $user, $password, $dbname;

	$cxn = new mysqli($host, $user, $password, $dbname, $port)
	or die ('Ocurrió un error al conectar con la base de datos.' . mysqli_connect_error());

	$query = "SELECT juego,(SELECT nombre from juegos WHERE juegos.id = accesos.juego) AS nombre, count(*) AS veces, (SELECT url from juegos WHERE juegos.id = accesos.juego) as enlace from accesos group by juego order by veces desc limit 10;";

	//Realiza la consulta
	if($result = mysqli_query($cxn,$query))
	{
		if(sizeof($result) > 0){
			//En caso de encontrar recultados
			echo ("<ul style=\"margin: 0; padding: 0;\">");
			while($row = mysqli_fetch_row($result)){
				echo("<li style=\"display:block; float:left; margin: 0; color: white; border: 1px solid #d00a0a; background-color: #d00a0a; font-weight: bold; border-radius: 3px; margin: 3px; padding: 3px;\"><a style=\"text-decoration: none; color: white;\" href=\"game.php?id=".$row[0]."\">".$row[1]." (".$row[2].")</a></li>");
			}
			echo ("</ul><div style=\"clear:both;\"></div>");
		}
		else
		{
			//En caso de no encontrarlos
			echo("Todav&iacute;a no has jugado a ning&uacute;n juego.");
		}
		mysqli_free_result($result);
	}

	mysqli_close($cxn);
}

function devuelveUsuariosMasActivosAdmin()
{

	global $host, $port, $user, $password, $dbname;

	$cxn = new mysqli($host, $user, $password, $dbname, $port)
	or die ('Ocurrió un error al conectar con la base de datos.' . mysqli_connect_error());

	$query = "SELECT usuario, (SELECT usuarios.usuario from usuarios where usuarios.id = accesos.usuario) AS nombre,count(*) AS veces from accesos group by usuario order by veces desc LIMIT 10;";

	//Realiza la consulta
	if($result = mysqli_query($cxn,$query))
	{
		if(sizeof($result) > 0){
			//En caso de encontrar recultados
			echo ("<ul style=\"margin: 0; padding: 0;\">");
			while($row = mysqli_fetch_row($result)){
				echo("<li style=\"display:block; float:left; margin: 0; color: white; border: 1px solid #d00a0a; background-color: #d00a0a; font-weight: bold; border-radius: 3px; margin: 3px; padding: 3px;\"><a style=\"text-decoration: none; color: white;\" href=\"user.php?user=".$row[1]."\">".$row[1]." (".$row[2].")</a></li>");
			}
			echo ("</ul><div style=\"clear:both;\"></div>");
		}
		else
		{
			//En caso de no encontrarlos
			echo("Todav&iacute;a no has jugado a ning&uacute;n juego.");
		}
		mysqli_free_result($result);
	}

	mysqli_close($cxn);
}

function devuelvePuntuaciones($idjuego)
{

	global $host, $port, $user, $password, $dbname;

	$cxn = new mysqli($host, $user, $password, $dbname, $port)
	or die ('Ocurrió un error al conectar con la base de datos.' . mysqli_connect_error());

	$query = "SELECT *,(SELECT usuario FROM usuarios WHERE usuarios.id = puntuacion.usuario) AS 'usu' from puntuacion WHERE juego=".$idjuego." ORDER BY puntuacion DESC LIMIT 10;";
	//Realiza la consulta
	if($result = mysqli_query($cxn,$query))
	{
		if(mysqli_num_rows($result) > 0){
			//En caso de encontrar recultados
			echo("<span>RANKING</span>");
			echo("<br />");
			echo ("<table id=\"tblPuntuaciones\">");
			echo("<tr id=\"cabecera\"><td>Pos.</td><td>Punt.</td><td>Usuario</td></tr>");
			$pos = 1;
			while($row = mysqli_fetch_row($result)){
				//echo(" < tr><td > X</td><td > ".$row[3]."</td><td > ".$row[1]."</td></td > ");
				echo("<tr><td>".$pos."&deg;&nbsp;</td><td>".$row[3]."</td><td>".$row[6]."</td></tr>");
				$pos += 1;
			}
			//echo ("</ul><div style = \"clear:both;\"></div > ");
			echo ("</table>");
		}
		else
		{
			//En caso de no encontrarlos
			echo("No hay puntuaciones.");
		}
		mysqli_free_result($result);
	}

	mysqli_close($cxn);
}
function listaMenu()
{

	echo("<div id=\"nav\">");

	global $host, $port, $user, $password, $dbname;
	
	$cxn = new mysqli($host, $user, $password, $dbname, $port)
	or die ('Ocurrió un error al conectar con la base de datos.' . mysqli_connect_error());

	$query = "SELECT DISTINCT Categoria FROM Juegos;";

	if($cxn->real_query ($query)){

		if($result = $cxn->store_result()){
			echo("<ul id=\"menu\">");
			echo("<li id=\"TODOS\" onclick=\"mostrar(this.id)\" style=\"color: #d00a0a;\">TODOS</li>");
			$nrows    = $result->num_rows;

			$all_rows = $result->fetch_all(MYSQLI_ASSOC);

			//crea los elementos de la lista a partir de los resultados
			for($i = 0; $i < count($all_rows); $i++){
				echo "<li id=\"".$all_rows[$i]['Categoria']."\" onclick=\"mostrar(this.id)\" title=\"".$all_rows[$i]['Categoria']."\">\n";
				echo($all_rows[$i]['Categoria']);
				echo "</li>\n";

			}
			echo("</ul>");
		}

		$result->close(); //liberamos recursos
	}
	echo("</div>");
}

function listaJuegos()
{
	global $host, $port, $user, $password, $dbname;

	$cxn = new mysqli($host, $user, $password, $dbname, $port)
	or die ('Ocurrió un error al conectar con la base de datos.' . mysqli_connect_error());

	$query = "SELECT * FROM juegos ORDER BY categoria, nombre;";

	if($cxn->real_query ($query)){

		if($result = $cxn->store_result()){
			echo("<ul id=\"listajuegos\">");
			$nrows    = $result->num_rows;

			$all_rows = $result->fetch_all(MYSQLI_ASSOC);

			//crea los elementos de la lista a partir de los resultados
			for($i = 0; $i < count($all_rows); $i++){
				if($all_rows[$i]['activo'] == 1){
					echo "<li id=\"".$all_rows[$i]['id']."\" onclick=\"popupInfoJuego(this.id)\" title=\"".$all_rows[$i]['nombre']."\" category=\"".$all_rows[$i]['categoria']."\">\n";
					echo "<div style=\"display: inline-block;\"><img src=\"".$all_rows[$i]['imagen']."\"><br><span style=\"display:inline-block;font-weight: bolder; font-size:0.8em; float: left; margin-left: 10px;\">".$all_rows[$i]['nombre']."</span>";

				}
				else
				{
					echo "<li id=\"".$all_rows[$i]['id']."\" title=\"".$all_rows[$i]['nombre']."\" category=\"".$all_rows[$i]['categoria']."\">\n";
					echo "<div style=\"display: inline-block;\"><img src=\"".$all_rows[$i]['imagen']."\"><br><span style=\"display:inline-block;font-weight: bolder; font-size:0.8em; float: left; margin-left: 10px;\">".$all_rows[$i]['nombre']." [Pronto]</span>";

				}

				//AGREGA ICONO DE RANKING ONLONE
				if($all_rows[$i]['puntuaciones'] == 1){
					echo("<img src=\"img/icon/tracking.jpg\" style=\"width: 16px; height: 16px; display: inline-block; margin: 0px; margin-right: 3px; box-shadow: none; float: right;\" title=\"Soporte de registro de puntuaciones en l&iacute;nea (para usuarios registrados)\"></img>");
				}

				//AGREGA ICONO DE LOGROS
				if($all_rows[$i]['logros'] == 1){
					echo("<img src=\"img/icon/achievement.jpg\" style=\"width: 16px; height: 16px; display: inline-block; margin: 0px; margin-right: 3px; box-shadow: none; float: right;\" title=\"Soporte de logros (para usuarios registrados)\"></img>");
				}

				//AGREGA ICONO DE TIPO DE JUEGO
				if($all_rows[$i]['tipo'] == 'PHASER'){
					echo("<img src=\"img/icon/phaser.png\" style=\"width: 16px; height: 16px; display: inline-block; margin: 0px; margin-right: 3px; box-shadow: none; float: right;\" title=\"Utiliza la librer&iacute;a Phaser.js\"></img>");
				}
				else
				if($all_rows[$i]['tipo'] == 'JSGB'){
					echo("<img src=\"img/icon/jsgb.png\" style=\"width: 16px; height: 16px; display: inline-block; margin: 0px; margin-right: 3px; box-shadow: none; float: right;\" title=\"Utiliza el emulador JSGB 0.02\"></img>");
				}
				else
				if($all_rows[$i]['tipo'] == 'FUSION'){
					echo("<img src=\"img/icon/fusion.png\" style=\"width: 16px; height: 16px; display: inline-block; margin: 0px; margin-right: 3px; box-shadow: none; float: right;\" title=\"Hecho con Clickteam Fusion\"></img>");
				}
				else
				if($all_rows[$i]['tipo'] == 'UNITY'){
					echo("<img src=\"img/icon/unity.png\" style=\"width: 16px; height: 16px; display: inline-block; margin: 0px; margin-right: 3px; box-shadow: none; float: right;\" title=\"Hecho con Unity 3D\"></img>");
				}
				else
				if($all_rows[$i]['tipo'] == 'NESBOX'){
					echo("<img src=\"img/icon/nesbox.png\" style=\"width: 16px; height: 16px; display: inline-block; margin: 0px; margin-right: 3px; box-shadow: none; float: right;\" title=\"Utiliza el emulador de c&oacute;digo abierto Nesbox\"></img>");
				}
				echo "</div></li>\n";
			}
			echo("</ul>");
		}

		$result->close(); //liberamos recursos
	}
}
function incrustaJuego($id)
{


	global $host, $port, $user, $password, $dbname;

	$cxn = new mysqli($host, $user, $password, $dbname, $port)
	or die ('Ocurrió un error al conectar con la base de datos.' . mysqli_connect_error());

	$query = "SELECT * FROM Juegos WHERE id = ".$id;

	if($cxn->real_query ($query))
	{

		if($result = $cxn->store_result())
		{
			$nrows    = $result->num_rows;

			$all_rows = $result->fetch_all(MYSQLI_ASSOC);

			$titulo   = $all_rows[0]['nombre'];
			$url      = $all_rows[0]['url'];
			$ayuda    = $all_rows[0]['ayuda'];
		}

		//Guarda estadisticas de acceso si el usuario esta logeado
		if(isset($_SESSION['usuario']))
		{
			guardaEstadisticasAcceso($_SESSION['usuario'],$all_rows[0]['id'] );
		}

		$result->close(); //liberamos recursos

		echo ("<span style=\"font-size: 3.0em; color: red; margin-top: -5px; float: left; font-weight: bolder;\">".$titulo."</span><img src=\"img/web/ayuda.png\" id=\"ayuda\" style=\"height: 1.2em; float: left; margin: 10px;\" title=\"".$ayuda."\"></img>");
		echo ("<br><br>");

		if(isset($_SESSION['usuario']))
		{
			$query = "SELECT id FROM usuarios WHERE usuario = '".$_SESSION['usuario']."' LIMIT 1";
			if($cxn->real_query ($query))
			{
				if($result = $cxn->store_result())
				{
					$nrows    = $result->num_rows;

					$all_rows = $result->fetch_all(MYSQLI_ASSOC);

					echo("<input id=\"userid\" type=\"hidden\" value=\"".$all_rows[0]['id']."\"></input>");
					$result->close();
				}
			}
		}
		else
		{
			echo("<input id=\"userid\" type=\"hidden\" value=\"0\"></input>");
		}
		//devuelvePuntuaciones($_GET['id']);
		?>
		<div id="divPuntuaciones" style="z-index: 1; position: absolute; right: 0px; top: 80px; width: 10%; height: 100px; padding: 0px; color: black; ">
			<?php
			devuelvePuntuaciones($_GET['id']);
			?>
		</div>
		<?php
		echo ("<iframe frameborder=\"0\" scrolling=\"no\" width=\"80%\" height=\"500px\"src=\"".$url."\"><p>iframes are not supported by your browser.</p></iframe><br><br>");
		//echo " < script > \$(function(){$('#ayuda').tooltip();});</script > ";
	}
}
?>