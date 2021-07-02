<script>

$(function(){
$('#false').hide();
});

if ($('#frmRegistro').length > 0) {
var frmvalidator = null;
var frmvalidator  = new Validator("frmRegistro");
 frmvalidator.addValidation("user","req","Introduce un nombre de usuario");
 frmvalidator.addValidation("user","maxlen=50", "La longitud maxima es de 50 caracteres");
 frmvalidator.addValidation("user","minlen=3", "La longitud minima es de 3 caracteres");
 frmvalidator.addValidation("pass","req","Introduce una contraseña");
 frmvalidator.addValidation("pass","maxlen=50", "La longitud maxima es de 50 caracteres");
 frmvalidator.addValidation("pass","minlen=3", "La longitud minima es de 3 caracteres");
 frmvalidator.addValidation("mail","maxlen=50", "La longitud maxima es de 50 caracteres");
 frmvalidator.addValidation("mail","req", "La direccion de correo-e es obligatoria");
 frmvalidator.addValidation("mail","email", "No es una direccion de correo valida");
}

function compruebaUsuario(nombre) {
		var params =
	{
		"nombre" : nombre
	}
	$.ajax(
		{
			data: params,
			url: 'checkuser.php',
			type: 'post',
			beforeSend: function ()
			{

			},
			success: function(response)
			{
				if(response!="") {
					$('#comprobador').html(response);
					$('#enviar').hide();
					$('#false').show();
					$("#frmRegistro").submit(function(event){ 				
						return false;
					}); 
				} else {
					$('#comprobador').html('');
					$('#enviar').show();
					$('#false').hide();
					$("#frmRegistro").submit(function(event){ 				
						document.getElementById("frmRegistro").submit();
					}); 
				}
			}


		});
}

</script>