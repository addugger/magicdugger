<?php

require_once("../dbConn.php");

if (isset($_GET["id"]) && isset($_GET["type"]) && isset($_GET["update"]))
{
	if ($_GET["type"] == "nonFoil")
	{
		$type = "CRD_COUNT";
	}
	else
	{
		$type = "CRD_FOIL_COUNT";
	}
	
	if ($_GET["update"] == "add")
	{
		$stmt = $conn -> prepare(
			"UPDATE MTG_CARDS
			SET $type = $type + 1 
			WHERE CRD_ID = :id");
	}
	else
	{
		$stmt = $conn -> prepare(
			"UPDATE MTG_CARDS
			SET $type = $type - 1
			WHERE CRD_ID = :id");
	}
	
	$stmt -> bindParam(":id", $_GET["id"], PDO::PARAM_INT);
	
	$stmt -> execute();	
}


?>