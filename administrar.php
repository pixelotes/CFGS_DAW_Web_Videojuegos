<?php include("funciones.php"); ?>	
<?php include("template/templ_header.html"); ?>
<?php include("template/templ_pre_content.html"); ?>
<?php
    if($_SESSION['usuario']=="admin"){
    	echo("<script type=\"text/javascript\">
         function calcHeight()
         {
         //find the height of the internal page
         var the_height=
         document.getElementById('the_iframe').contentWindow.
         document.body.scrollHeight;

         //change the height of the iframe
         document.getElementById('the_iframe').height=
         the_height + 130;
         }</script>");
    	echo("<div style=\"clear:both;\"></div>");
    	echo("<div style=\"margin: 10px; float: left;\"><a href=\"index.php\" style=\"text-decoration: none;\"><img src=\"img/web/volver.png\" style=\"height: 1.5em;\"></img><span style=\"margin-right: 50px; font-size: 2.0em; color: red; vertical-align: center;\">&nbsp;VOLVER</span></a></div>");
		echo ("<iframe id=\"the_iframe\" frameborder=\"0\" scrolling=\"no\" width=\"80%\" height=\"100%\" onLoad=\"calcHeight();\" src=\"backend/principal.php\"><p>iframes are not supported by your browser.</p></iframe><br><br>");
		echo("<div style=\"clear:both;\"></div>");
    } else {
		echo("Debes ser administrador para poder visualizar esta p&aacute;gina.");
    }
        	
?>
<?php include("template/templ_post_content.html"); ?>