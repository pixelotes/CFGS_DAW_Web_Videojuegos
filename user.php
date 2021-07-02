<?php include("funciones.php"); ?>	
<?php include("template/templ_header.html"); ?>
<?php include("template/templ_pre_content.html"); ?>
<?php
if((isset($_SESSION['usuario']) && $_SESSION['usuario']==$_GET['user'])||isset($_SESSION['usuario']) && $_SESSION['usuario']=="admin") { 
    echo("<div style=\"margin: 10px; float: left;\"><a href=\"index.php\" style=\"text-decoration: none;\"><img src=\"img/web/volver.png\" style=\"height: 1.5em;\"></img><span style=\"margin-right: 50px; font-size: 2.0em; color: red; vertical-align: center;\">&nbsp;VOLVER</span></a></div>");
    echo ("<span style=\"font-size: 3.0em; color: red; margin-top: -5px; float: left; font-weight: bolder;\">"."Estad&iacute;sticas de ".$_GET['user']."</span>");
    echo ("<br><br>");
    echo ("<div style=\"clear:both;\"></div>");
    if($_SESSION['usuario']=="admin" && $_GET['user']=="admin"){
		    echo ("<div id=\"pnlAdmin\" style=\"width: 94%; float: left; border: 2px solid red; border-radius: 5px; margin:1%;padding: 1%; min-height: 100px;display:block;left:50%;right:50%;\">");
    echo ("<p>Top 10 m&aacute;s jugados</p>");
    devuelveMasJugadosAdmin();
    echo ("<p>Usuarios m&aacute;s activos</p>");
    devuelveUsuariosMasActivosAdmin();
    echo("</div>");
	}
    echo ("<div id=\"pnlIzq\" style=\"width: 45%; float: left; border: 2px solid red; border-radius: 5px; margin:1%; padding: 1%; min-height: 100px;display:block;\">");
    echo ("<p>&Uacute;ltimos juegos jugados</p>");
    //crea un listado de los ultimos juegos jugados
    devuelveUltimosJugados($_GET['user'], 10); //usuario, cantidad a recuperar
    echo ("<p>Juegos preferidos</p>");
    //crea un listado de los juegos mas jugados
    devuelveMasJugados($_GET['user'], 10); //usuario, cantidad a recuperar
    echo ("<p>&Uacute;ltimos comentarios</p>");
    //muestra los ultimos comentarios
    devuelveComentarios($_GET['user'],0,3); //usuario, id de juego (0 para todos los comentarios), numero de comentarios a recuperar (0 para todos los comentarios)
    echo ("</div>");
    echo ("<div id=\"pnlDer\" style=\"width: 45%; float: left; border: 2px solid red; border-radius: 5px; margin:1%;padding: 1%; min-height: 100px;display:block;\">");
    echo ("<p>Logros</p>");
    //crea un listado de logros
    devuelveLogros($_GET['user'],0); //usuario, id de juego (0 para todos los juegos)
    echo("</div>");
    echo ("<div style=\"clear:both;\"></div>");
} else {
	echo ("<span style=\"font-size: 3.0em; color: red; margin-top: -5px; float: left; font-weight: bolder;\">Debes de estar logueado para ver tus estad&iacute;sticas</span>");
}
?>
<?php include("template/templ_post_content.html"); ?>