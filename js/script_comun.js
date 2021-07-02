	    //inicializa los elementos de la pagina
$(function ()
	{
		$("#login").hide();

		$( "#dialogJuego" ).hide();

		$("#btnMenuLogin").click(function ()
			{
				$("#login").slideToggle();
			});

		$("#btnMenuRegistro").click(function ()
			{
				window.open('registro.php','_self');
			});

		$("#btnAdministrar").click(function ()
			{
				//window.open('backend/principal.php','_this');
				window.open('administrar.php','_self');
			});

		$("#btnLogin").click(function ()
			{
				nom=$('#userId').val();
				pas=$('#userPass').val();
				window.open('login.php?userId='+nom+'&userPass='+pas,'_self');
			});

		$("#btnDesconectar").click(function ()
			{
				window.open('desconectar.php','_self');
			});


		//$('#menu').slicknav({label: "CATEGOR&Iacute;AS"});
		
		function recuperar()
			{
				//alert("hola");
				dircorreo =$('#correo').val();
				window.open('recuperar.php?correo='+dircorreo,'_self');
			}
		
		$("#btnRec").click(function()
			{
				//alert("hola");
				dircorreo =$('#correo').val();
				window.open('recuperar.php?correo='+dircorreo,'_self');
			});
		$("#listajuegos li").hover(function()
			{
				$(this).css({ opacity: 0.7 });
			},function()
			{
				$(this).css({ opacity: 1.0 });
			});

		$("#nav li").click(function()
			{
				$("#nav li").css({ color: 'black' });
				$(this).css({ color: '#d00a0a' });
			});

		$("#listajuegos li").tooltip();

		$("#ayuda").tooltip();

	});

        //muestra la categoria
        function mostrar(id) {
			if(id=='TODOS') {
				$("#listajuegos li").show();
			} else {
				$("#listajuegos li").hide();
				$("#listajuegos li[category="+id+"]").show();
			}
        }

//muestra una ventana con informacion del juego
function popupInfoJuego(id)
{
	var params =
	{
		"idjuego" : id
	}
	$.ajax(
		{
			data: params,
			url: 'info.php',
			type: 'post',
			beforeSend: function ()
			{
				$("#dialogJuego").html("Procesando, espere por favor...");
			},
			success: function(response)
			{
				datos = response.split("||");
				contenido = "<div id='pIzq' style='float:left; width: 55%;'><span id='pDesc'>"+datos[4]+"</span></div><div id='pDer' style='float:right; width: 45%;'><img style='width: 130px;margin:10px; border: 1px solid black;' id='pThumb' src='"+datos[3]+"'></img><br><br><a style='float:right;background-color:red;text-decoration:none;font-weight:bold;font-size:0.8em;color:white;padding: 6px;' id='pPlay' href='game.php?id="+id+"'>JUGAR</a></div>";
				$( "#dialogJuego" ).html(contenido); //contenido
				$( "#dialogJuego" ).dialog({modal:true,title:datos[0],width:350,draggable:false});
			}
		});
}

function validar(e)
{
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla==13) document.getElementById("btnLogin").click();
}