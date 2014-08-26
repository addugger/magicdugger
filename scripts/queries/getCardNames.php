<?php

require_once("../dbConn.php");

if (isset($_GET["term"]))
{
	$term = $_GET["term"];
	
	$stmt = $conn -> prepare(
		"SELECT CRD_ID, CRD_NAME, SET_NAME
		FROM MTG_CARDS crd
		LEFT JOIN MTG_SETS st ON crd.SET_ID = st.SET_ID
		WHERE UPPER(CRD_NAME) LIKE UPPER(" . $conn -> quote("%" . $term . "%") . ")");
	
	if ($stmt -> execute())
	{
		$results = array();
		while ($row = $stmt -> fetch())
		{
			$curRs = array();
			$curRs["label"] = "$row[CRD_NAME] ($row[SET_NAME])";
			$curRs["value"] = "$row[CRD_ID]";
			array_push($results, $curRs);
		}
		echo(json_encode($results));
	}
}

?>