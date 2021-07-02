<?php include("funciones.php"); ?>	
<?php include("template/templ_header.html"); ?>
<?php include("template/templ_pre_content.html"); ?>

<?php
echo("<div id=\"volver\" style=\"margin: 10px; display:block;;\"><a href=\"index.php\" style=\"text-decoration: none;\"><img src=\"img/web/volver.png\" style=\"height: 1.5em;\"></img><span style=\"margin-right: 50px; font-size: 2.0em; color: red; vertical-align: center;\">&nbsp;VOLVER</span></a></div>");
    if(isset($_GET['correo'])) {
		recuperaPass($_GET['correo']);
		echo("<center><br><br><br>En caso de que existan se enviar&aacute;n los datos de acceso a la cuenta ".$_GET['correo']."<br><button id=\"btnVolver\" onclick=\"window.open('index.php','_self');\">Volver</button></center>");
    } else {
		echo("<div id=\"recuperar\">");
		echo("<span>Introduce tu correo: </span>");
		echo("<input type=\"text\" id=\"correo\"></input>");
		echo("<button id=\"btnRec\">Recuperar</button>");
		echo("</div>");
    }
?>
<?php include("template/templ_post_content.html"); ?>