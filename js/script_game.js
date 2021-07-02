
$(function()
	{
		$('#commentBox').hide();
		$('#commentAdd').hide();
		$('#commentDiv').hide();
	});

var muestra = false;

function muestraComentarios()
{
	muestra = !muestra;
	if(muestra)
	{
		$('#commentBox').slideDown();
		$('#commentToggle').html('ocultar');
		$('#commentAdd').show();
	} else
	{
		$('#commentBox').slideUp();
		$('#commentToggle').html('ver');
		$('#commentAdd').hide();
	}
}

function agregaComentario(usu)
{
	//alert("caca");
	//$("commentDiv").show();
	$("#commentDiv").dialog({modal:true,title:"Comentar",width:500,draggable:false});
}

function eliminaComentario(id)
{

	var params =
	{
		"id" : id
	}
	$.ajax(
		{
			data: params,
			url: 'delete.php',
			type: 'post',
			beforeSend: function ()
			{
				/*var text ='PARAMETROS \n';
				for(key in params)
				text += (key + ' = ' + params[key] + '\n');

				alert(text);*/
				//$("#commentDiv").html("Procesando, espere por favor...");
			},
			success: function(response)
			{
				setTimeout(function()
					{
						$("#commentDiv").dialog('close');
						refreshComments();
					}, 500);
				refreshComments();
			}


		});
}

function refreshComments()
{
	//refresca documentos
	var params =
	{
		"get" : "ok",
		"id"  :  location.search.split('id=')[1]
	}
	$.ajax(
		{
			data: params,
			url: 'post.php',
			type: 'post',
			beforeSend: function ()
			{
			},
			success: function(response)
			{
				$('#contenedorComentarios').html(response);
				$('#commentText').val('');
				$('#commentToggle').html('ocultar');
			}
		});
}

function refreshRanking()
{
	//refresca documentos
	var params =
	{
		"id"  :  location.search.split('id=')[1]
	}
	$.ajax(
		{
			data: params,
			url: 'ranking.php',
			type: 'post',
			beforeSend: function ()
			{
			},
			success: function(response)
			{
				$('#divPuntuaciones').html(response);
			}
		});
}

$(function()
	{
		$("#commentButton").click(function()
			{
				var texto = $("#commentText").val();

				var params =
				{
					"texto" : texto,
					"id" : location.search.split('id=')[1]
				}
				$.ajax(
					{
						data: params,
						url: 'post.php',
						type: 'post',
						beforeSend: function ()
						{
							/*var text ='PARAMETROS \n';
							for(key in params)
							text += (key + ' = ' + params[key] + '\n');

							alert(text);*/
							//$("#commentDiv").html("Procesando, espere por favor...");
						},
						success: function(response)
						{
							setTimeout(function()
								{
									$("#commentDiv").dialog('close');
									refreshComments();
								}, 500);
							
						}
					});
			});
	});

//muestra la categoria
function mostrar(id)
{
	if(id=='TODOS')
	{
		$("#listajuegos li").show();
	} else
	{
		$("#listajuegos li").hide();
		$("#listajuegos li[category="+id+"]").show();
	}
}