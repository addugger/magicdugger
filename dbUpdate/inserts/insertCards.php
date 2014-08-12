<?php
require_once("../../scripts/dbConn.php");

require_once("insertSets.php");

$cards;
foreach ($setArray as $setAbr)
{
	$cards = json_decode(file_get_contents("http://api.mtgdb.info/sets/$setAbr/cards/"));
}

?>