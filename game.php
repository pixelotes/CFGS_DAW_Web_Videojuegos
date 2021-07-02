<?php include("funciones.php"); ?>
<?php include("template/templ_header.html"); ?>
<?php include("template/templ_pre_content.html"); ?>
<?php
$id = $_GET['id'];
echo("<div id=\"volver\" style=\"margin: 10px; float: left;\"><a href=\"index.php\" style=\"text-decoration: none;\"><img src=\"img/web/volver.png\" style=\"height: 1.5em;\"></img><span style=\"margin-right: 50px; font-size: 2.0em; color: red; vertical-align: center;\">&nbsp;VOLVER</span></a></div>");
//MOSTRAR JUEGO
incrustaJuego($id);
echo("<div id=\"contenedorComentarios\">");
//if (isset($_SESSION['usuario']) && $_SESSION['usuario']!="invitado") { guardaEstadisticasAcceso($_SESSION['usuario'],$id); }
generaComentarios($_GET['id']);
echo("</div>");
?>
<?php include("template/templ_comment.html"); ?>
<?php include("template/templ_post_content.html"); ?>