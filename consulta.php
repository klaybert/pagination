<?php
require("clases.php");

if(isset($_POST["limite"]))
{
	$limite = $_POST["limite"];
}else
{
	$limite = 0;
}

if(isset($_POST["dato"]))
{
	$campo = $_POST["campo"];
	// echo $campo."echo numero 1<br>";
	$dato = $_POST["dato"];
	$pag = $_POST["pag"];

	$selecton = new Selector("alumnos","");
	$ej = $selecton->h_query();

	if($campo == "general")
	{
		$condicion = "ORDER BY codigo_alumno DESC LIMIT $limite, $pag ";
	}
	else
	{
		$condicion="WHERE $campo LIKE '%$dato%'";
		// echo $condicion;
	}
	$array_envio = [];
	$selecton = new Selector("alumnos",$condicion);
	$campos_array = $selecton->h_campos_array();
	$ej = $selecton->h_query();
	if($ej)
	{
		$fila = $selecton->h_query();
		foreach ($fila as $row)
		{
			for($i=0; $i<count($campos_array);$i++)
			{
				array_push($array_envio,$row[$campos_array[$i]]);
			}
		}
			array_push($array_envio, $pag);
			print_r(json_encode($array_envio));
	}
	else
	{
		echo 1;
	}


}



?>