<?php
require_once("../../scripts/dbConn.php");

$chkSetStmt = "SELECT SET_ID FROM MTG_SETS WHERE SET_ABR = ':setAbr'";

$insertSetStmt = $conn -> prepare(
	"INSERT INTO MTG_SETS
	(
		SET_ABR,
		SET_TYPE,
		SET_NAME,
		SET_BLOCK,
		SET_DESCRIPTION,
		SET_COMMON,
		SET_UNCOMMON,
		SET_RARE,
		SET_MYTHIC_RARE,
		SET_BASIC_LAND,
		SET_TOTAL,
		SET_RELEASE_DATE
	)
	VALUES
	(
		:_abr,
		:_type,
		:_name,
		:_block,
		:_description,
		:_commonCnt,
		:_uncommonCnt,
		:_rareCnt,
		:_mythicRareCnt,
		:_basicLandCnt,
		:_totalCnt,
		:_date
	)"
);

function hasSet($setAbr)
{
	global $conn, $chkSetStmt;
	$hasSet = false;
	$results = $conn -> query(str_replace(":setAbr", $setAbr, $chkSetStmt));
	if ($row = $results -> fetch())
	{
		$hasSet = true;
	}
	return $hasSet;
}

function insertSet($set)
{
	global $conn, $insertSetStmt;
	$insertSetStmt -> bindParam(":_abr", $set["id"], PDO::PARAM_STR);
	$insertSetStmt -> bindParam(":_type", $set["type"], PDO::PARAM_STR);
	$insertSetStmt -> bindParam(":_name", $set["name"], PDO::PARAM_STR);
	$insertSetStmt -> bindParam(":_block", $set["block"], PDO::PARAM_STR);
	$insertSetStmt -> bindParam(":_description", $set["description"], PDO::PARAM_LOB);
	$insertSetStmt -> bindParam(":_commonCnt", $set["common"], PDO::PARAM_INT);
	$insertSetStmt -> bindParam(":_uncommonCnt", $set["uncommon"], PDO::PARAM_INT);
	$insertSetStmt -> bindParam(":_rareCnt", $set["rare"], PDO::PARAM_INT);
	$insertSetStmt -> bindParam(":_mythicRareCnt", $set["mythicRare"], PDO::PARAM_INT);
	$insertSetStmt -> bindParam(":_basicLandCnt", $set["basicLand"], PDO::PARAM_INT);
	$insertSetStmt -> bindParam(":_totalCnt", $set["total"], PDO::PARAM_INT);
	$insertSetStmt -> bindParam(":_date", $set["releasedAt"], PDO::PARAM_STR);
	
	$insertSetStmt -> execute();
	$insertSetStmt -> closeCursor();
}

$sets = json_decode(file_get_contents("http://api.mtgdb.info/sets/"), true);

$count = 0;

foreach ($sets as $set)
{
	if (!hasSet($set["id"]))
	{
		insertSet($set);
		echo($set["id"] . " inserted.<br>");
		$count++;
	}
}
echo($count);

?>