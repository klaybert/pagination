<?php
require("clases.php");
$selecton = new Selector("alumnos", "");
$campos = $selecton->h_campos_array();
// print_r($campos);
$a="<thead><tr>";
foreach ($campos as $row) 
{
	$a.="<th scope='col'>".ucfirst($row)."</th>";
}
$a.= "</tr></thead>";

?>

<!DOCTYPE html>
<html>
<head>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script> 	
	<title>Ejercicio consultas</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
<div class="container">
	<h1>Busqueda por diferentes opciones</h1>

	<form class="form-group">
		<select name="campos" id="select">
			<option value="general">General</option>
			<?php
				for($i=0;$i<count($campos);$i++)
				{
					echo '<option value="'.$campos[$i].'">'.$campos[$i].'</option>';
				}
			?>
		</select>
		<input type="text">
	</form>
	<button onclick="consulta()" >Consulta</button>
	<select name="campos_indv" id="select_campos" onchange="consulta()">
			<option value="5">5</option>
			<option value="10">10</option>
			<option value="15">15</option>
			<option value="20">20</option>
			<option value="25">25</option>
			
		</select>
<hr>
<div id="resultados">
	<table id="table" class="table table-hover">

		
	</table>
</div>
<div id="ultimo"></div>

<center>
<div id="pagination1"></div>
</center>

<div id="limite" style="display: none"></div>
<script type="text/javascript">
	function consulta()
	{
		$("table").text("");
		var limite = $("div#limite").text();
		alert(limite);
		var pag = $("select#select_campos").val();
		var formulario = new FormData();
		var campo = $("select#select").val();
		var dato = $("input[type=text]").val();
		formulario.append("pag", pag);
		formulario.append("campo", campo);
		if(limite == "")
		{
		}
		else
		{
			formulario.append("limite", limite);
		}
		if(campo == "general")
		{
			dato = "";
			$("input[type=text]").val("");
		}
		formulario.append("dato", dato);

		$.ajax({
			url:"consulta.php",
			type:"post",
			data:formulario, // Esto es una variable donde encapsulo todo en un objeto, 
							 //que tiene tantos input como le he dicho que el tiene adentro, y va por post con un contenedor. 
			contentType:false, //cabeceras, 
			processData:false, //Para que no codifique la data
			success: function(mensaje)//si es exitoso lo recogido, se muestra en la funcion
			{
				// alert(mensaje);
				mensaje = JSON.parse(mensaje);
				if(mensaje == 1)
				{
					alert("No hay resultados");
				}
				else
				{
					$("table").append("<?php echo($a);?>");
			
					var last_id = mensaje[0];
					var num = mensaje.length;
					var pag = mensaje[num-1];

					for(i=0;i<mensaje.length-1;i=i+4)
					{
						if(i == 0)
						{

						}

						$("table").append("<tr><td>"+mensaje[i]+"</td><td>"+mensaje[i+1]+"</td><td>"+mensaje[i+2]+"</td><td>"+mensaje[i+3]+"</td></tr>");
					}
					//aqui hacemos la $("div#pagination")
					$("div#ultimo").html("<p> El ultimo valor es: "+last_id+"</p>");				
					pagination(last_id, pag);
				}
			} 
		});
		
	}

	function pagination(...arguments)
	{
		$("div#pagination1").text("");
		var last = arguments[0];
		var pag = arguments[1];	
		pag = parseInt(pag);	
		var a = 1;
		$.post(
			"pagination.php",
			{datos:pag},
			function(recibo)
			{
				var j = 0;
				var pagina = 0;
				for(i=1;i<=recibo;i++)
				{
					
					$("div#pagination1").append("<a href='#' onclick='buscar("+pagina+")'>"+i+"</a>"+" - ");
					pagina = pag+j;
					j=j+pag;
				}
			});
	}

	function buscar(vari)
	{
		var limite = vari;
		$("div#limite").text(limite);
		consulta();


	}

</script>

</div>
</body>
</html>