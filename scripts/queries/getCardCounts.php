<?php

require_once("../dbConn.php");

if (isset($_GET["id"]))
{

	$stmt = $conn -> prepare(
		"SELECT CRD_COUNT, CRD_FOIL_COUNT, CRD_WANT_COUNT, CRD_FOIL_WANT_COUNT
		FROM MTG_CARDS
		WHERE CRD_ID = :id");
	
	$stmt -> bindParam(":id", $_GET["id"], PDO::PARAM_INT);
	
	if ($stmt -> execute())
	{
		$results = array();
		$row = $stmt -> fetch();
		$results["nonFoilCnt"] = "$row[CRD_COUNT]";
		$results["foilCnt"] = "$row[CRD_FOIL_COUNT]";
		$results["nonFoilWantCnt"] = "$row[CRD_WANT_COUNT]";
		$results["foilWantCnt"] = "$row[CRD_FOIL_WANT_COUNT]";

		echo(json_encode($results));
	}
	
}


?>