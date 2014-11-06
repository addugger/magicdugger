<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
?>

<html>
	<head>
		<meta charset="ISO-8859-1">
		
		<link rel="stylesheet" href=//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css>
		<link rel="stylesheet" href=css/magicdugger.css>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
		<script src="models/funcs.js" type="text/javascript"></script>
	</head>

<?php
$pages = getPageFiles(); //Retrieve list of pages in root usercake folder
$dbpages = fetchAllPages(); //Retrieve list of pages in pages table
$creations = array();
$deletions = array();

//Check if any pages exist which are not in DB
foreach ($pages as $page){
	if(!isset($dbpages[$page])){
		$creations[] = $page;	
	}
}

//Enter new pages in DB if found
if (count($creations) > 0) {
	createPages($creations)	;
}

if (count($dbpages) > 0){
	//Check if DB contains pages that don't exist
	foreach ($dbpages as $page){
		if(!isset($pages[$page['page']])){
			$deletions[] = $page['id'];	
		}
	}
}

//Delete pages from DB if not found
if (count($deletions) > 0) {
	deletePages($deletions);
}

//Update DB pages
$dbpages = fetchAllPages();

include_once("scripts/banner.php");
include_once("scripts/menubar.php");

echo "
<body>
<div id='top'></div>";

include("left-nav.php");

echo "
<div id='main'>
<h2>Admin Pages</h2>
<table class='admin'>
<tr><th>Id</th><th>Page</th><th>Access</th></tr>";

//Display list of pages
foreach ($dbpages as $page){
	echo "
	<tr>
	<td>
	".$page['id']."
	</td>
	<td>
	<a href ='admin_page.php?id=".$page['id']."'>".$page['page']."</a>
	</td>
	<td>";
	
	//Show public/private setting of page
	if($page['private'] == 0){
		echo "Public";
	}
	else {
		echo "Private";	
	}
	
	echo "
	</td>
	</tr>";
}

echo "
</table>
</div>
<div id='bottom'></div>
</body>
</html>";

?>
