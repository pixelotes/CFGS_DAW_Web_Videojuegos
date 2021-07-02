<?php include("funciones.php"); ?>	
<?php include("template/templ_header.html"); ?>
<?php include("template/templ_pre_content.html"); ?>
<?php include("js/gen_validatorv4.js"); ?>
<?php
echo("<div id=\"volver\" style=\"margin: 10px; display:block;;\"><a href=\"index.php\" style=\"text-decoration: none;\"><img src=\"img/web/volver.png\" style=\"height: 1.5em;\"></img><span style=\"margin-right: 50px; font-size: 2.0em; color: red; vertical-align: center;\">&nbsp;VOLVER</span></a></div>");
if($_POST) {
	if(registraUsuario($_POST['user'],$_POST['pass'],$_POST['mail'])) {
		echo("<center><br><br><br>El registro de usuario se ha realizado con &eacute;xito.<br><button id=\"btnVolver\" onclick=\"window.open('index.php','_self');\">Volver</button></center>");
	} else {
		echo("<center><br><br><br>Ocurri&oacute; un problema al realizar el registro. Por favor, int&eacute;ntalo m&aacute;s tarde.<br><button id=\"btnVolver\" onclick=\"window.open('index.php','_self');\">Volver</button></center>");
	}
} else {
	echo("<form action='registro.php' method='post' id='frmRegistro'>");
	echo("<span>Usuario:</span><input name=\"user\" type=\"text\" size=\"16\" onblur=\"compruebaUsuario(this.value)\"/><span id=\"comprobador\" style=\"color:red;\"></span><br><span>Contrase&ntilde;a:</span><input name=\"pass\" type=\"password\" size=\"16\" /><br><span>Correo:</span><input name=\"mail\" type=\"text\" size=\"32\" /><br><button id=\"enviar\" name=\"enviar\" type=\"submit\">Ingresar</button><button disabled=\"disabled\" id=\"false\" style=\"background-color:white;color:black;\">Ingresar</button>");
	echo("</form>");
}
	
include("js/script_validacion.js");	
	
?>
<?php include("template/templ_post_content.html"); ?>