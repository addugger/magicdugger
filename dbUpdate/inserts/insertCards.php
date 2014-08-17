<?php
require_once("../../scripts/dbConn.php");

require_once("insertSets.php");

function getColorIds()
{
	global $conn;
	$colorIds = array();
	$colorIdStmt = $conn -> prepare("SELECT COL_ID FROM MTG_COLORS WHERE COL_ABREVIATION = :color");
	$colorIdStmt -> bindParam(":color", $color);
	$color = "W";
	$colorIdStmt -> execute();
	$rs = $colorIdStmt ->  fetch();
	$colorIds["white"] = $rs[0];
	$color = "U";
	$colorIdStmt -> execute();
	$rs = $colorIdStmt ->  fetch();
	$colorIds["blue"] = $rs[0];
	$color = "B";
	$colorIdStmt -> execute();
	$rs = $colorIdStmt ->  fetch();
	$colorIds["black"] = $rs[0];
	$color = "R";
	$colorIdStmt -> execute();
	$rs = $colorIdStmt ->  fetch();
	$colorIds["red"] = $rs[0];
	$color = "G";
	$colorIdStmt -> execute();
	$rs = $colorIdStmt ->  fetch();
	$colorIds["green"] = $rs[0];
	$color = "C";
	$colorIdStmt -> execute();
	$rs = $colorIdStmt ->  fetch();
	$colorIds["colorless"] = $rs[0];
	return $colorIds;
}

function getSetId($setAbr)
{
	global $conn;
	$setIdStmt = $conn -> query("SELECT SET_ID FROM MTG_SETS WHERE SET_ABR = " . $conn -> quote($setAbr));
	$row = $setIdStmt -> fetch();
	return $row[0];
}

function insertColors($cardId, $colors)
{
	global $conn, $colorIds;
	
	$crdColStmt = $conn -> prepare(
		"INSERT INTO MTG_CRD_MTG_COL (CRD_ID, COL_ID) VALUES(" . $conn -> quote($cardId) . ", :colId)");
	//check if colorless
	if (count($colors) == 1 && strcasecmp($colors[0], "none") == 0)
	{
		$crdColStmt -> bindValue(":colId", $colorIds["colorless"]);
		$crdColStmt -> execute();
	}
	//add each color
	else
	{
		foreach ($colors as $color)
		{
			$crdColStmt -> bindValue(":colId", $colorIds[strtolower($color)]);
			$crdColStmt -> execute();
		}
	}
}

function setNulls()
{
	global $setId,
		$multiverseId,
		$relatedId,
		$setNumber,
		$name,
		$srchName,
		$description,
		$flavor,
		$manaCost,
		$convertedManaCost,
		$type,
		$subType,
		$power,
		$toughness,
		$loyalty,
		$rarity,
		$artist,
		$token,
		$promo,
		$releaseDate;
	$setId = null;
	$multiverseId = null;
	$relatedId = null;
	$setNumber = null;
	$name = null;
	$srchName = null;
	$description = null;
	$flavor = null;
	$manaCost = null;
	$convertedManaCost = null;
	$type = null;
	$subType = null;
	$power = null;
	$toughness = null;
	$loyalty = null;
	$rarity = null;
	$artist = null;
	$token = null;
	$promo = null;
	$releaseDate = null;
}

set_time_limit(0);

//initialize card insert stmt
$insertCrdStmt = $conn -> prepare(
	"INSERT INTO  MTG_CARDS 
	(
		SET_ID,
		CRD_MULTIVERSE_ID,
		CRD_RELATED_ID,
		CRD_SET_NUMBER,
		CRD_NAME,
		CRD_SEARCH_NAME,
		CRD_DESCRIPTION,
		CRD_FLAVOR,
		CRD_MANA_COST,
		CRD_CONVERTED_MANA_COST,
		CRD_TYPE,
		CRD_SUB_TYPE,
		CRD_POWER,
		CRD_TOUGHNESS,
		CRD_LOYALTY,
		CRD_RARITY,
		CRD_ARTIST,
		CRD_TOKEN,
		CRD_PROMO,
		CRD_RELASE_DATE
	) 
	VALUES
	(
		:setId,
		:multiverseId,
		:relatedId,
		:setNumber,
		:name,
		:srchName,
		:description,
		:flavor,
		:manaCost,
		:convertedManaCost,
		:type,
		:subType,
		:power,
		:toughness,
		:loyalty,
		:rarity,
		:artist,
		:token,
		:promo,
		:releaseDate
	)");

//bind parameters to variables
$insertCrdStmt -> bindParam(":setId", $setId, PDO::PARAM_INT);
$insertCrdStmt -> bindParam(":multiverseId", $multiverseId, PDO::PARAM_INT);
$insertCrdStmt -> bindParam(":relatedId", $relatedId, PDO::PARAM_INT);
$insertCrdStmt -> bindParam(":setNumber", $setNumber, PDO::PARAM_INT);
$insertCrdStmt -> bindParam(":name", $name, PDO::PARAM_STR);
$insertCrdStmt -> bindParam(":srchName", $srchName, PDO::PARAM_STR);
$insertCrdStmt -> bindParam(":description", $description, PDO::PARAM_LOB);
$insertCrdStmt -> bindParam(":flavor", $flavor, PDO::PARAM_LOB);
$insertCrdStmt -> bindParam(":manaCost", $manaCost, PDO::PARAM_STR);
$insertCrdStmt -> bindParam(":convertedManaCost", $convertedManaCost, PDO::PARAM_INT);
$insertCrdStmt -> bindParam(":type", $type, PDO::PARAM_STR);
$insertCrdStmt -> bindParam(":subType", $subType, PDO::PARAM_STR);
$insertCrdStmt -> bindParam(":power", $power, PDO::PARAM_INT);
$insertCrdStmt -> bindParam(":toughness", $toughness, PDO::PARAM_INT);
$insertCrdStmt -> bindParam(":loyalty", $loyalty, PDO::PARAM_INT);
$insertCrdStmt -> bindParam(":rarity", $rarity, PDO::PARAM_STR);
$insertCrdStmt -> bindParam(":artist", $artist, PDO::PARAM_STR);
$insertCrdStmt -> bindParam(":token", $token, PDO::PARAM_BOOL);
$insertCrdStmt -> bindParam(":promo", $promo, PDO::PARAM_BOOL);
$insertCrdStmt -> bindParam(":releaseDate", $releaseDate, PDO::PARAM_STR);
setNulls();

$cards;
$colorIds = getColorIds();

foreach ($setArray as $setAbr)
{
	$cards = json_decode(file_get_contents("http://api.mtgdb.info/sets/$setAbr/cards/"), true);
	foreach ($cards as $card)
	{
		setNulls();
		$setId = getSetId($setAbr);
		$multiverseId = $card["id"];
		$relatedId = $card["relatedCardId"];
		$setNumber = $card["setNumber"];
		$name = $card["name"];
		$srchName = $card["searchName"];
		$description = $card["description"];
		$flavor = $card["flavor"];
		$manaCost = $card["manaCost"];
		$convertedManaCost = $card["convertedManaCost"];
		$type = $card["type"];
		$subType = $card["subType"];
		$power = $card["power"];
		$toughness = $card["toughness"];
		$loyalty = $card["loyalty"];
		$rarity = $card["rarity"];
		$artist = $card["artist"];
		$token = $card["token"];
		$promo = $card["promo"];
		$releaseDate = $card["releasedAt"];
		
		if ($insertCrdStmt -> execute())
		{
			insertColors($conn -> lastInsertId(), $card["colors"]);
		}
		else
		{
			exit(print_r($insertCrdStmt -> errorInfo()));
		}
	}
}

echo("done");

?>