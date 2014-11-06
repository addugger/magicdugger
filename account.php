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
include_once("scripts/banner.php");
include_once("scripts/menubar.php");

echo "
<body>
<div id='top'></div>";

include("left-nav.php");

echo "
<div id='main'>
<h2>User Page</h2>
Hey, $loggedInUser->displayname!  This page is your homepage...I, uh guess. It doesn't
really do anything right now, but I bet one day it'll be awesome!
</div>
<div id='bottom'></div>
</body>
</html>";

?>
