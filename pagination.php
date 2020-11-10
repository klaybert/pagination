<?php
include("clases.php");
if (isset($_POST["datos"])) 
{
	$pag = $_POST["datos"];
	$selecton = new Selector("alumnos","");
	$ej = $selecton->h_query();
	$pag_row = $ej->num_rows;
	$pagination = ceil($pag_row/$pag);
	echo $pagination;
}









?>