<?php
include("funciones.php");
//session_start();
if(isset($_GET['userId']) && isset($_GET['userPass'])) {	
		if(checkLogin($_GET['userId'],$_GET['userPass'])) {
				$_SESSION["usuario"]=$_GET['userId'];
				$_SESSION["logeado"]=true;
		} else {
				$_SESSION["usuario"]=null;
				$_SESSION["logeado"]=false;
		}
} else {
	//No se puede acceder a esta pagina directamente
}

//redirige a la página principal
//$redir = dirname ( "http://localhost/prj/index.php?");
//header ( "Location: http://localhost/prj/index.php?" );
?>
<html>
<head>
<title></title>
<script src="js/jquery.min.js"></script>
<script>
$(function() {
	window.open('index.php','_self');
});
</script>
</head>
<body>
</body>
</html>
