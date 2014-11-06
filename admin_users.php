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
//Forms posted
if(!empty($_POST))
{
	$deletions = $_POST['delete'];
	if ($deletion_count = deleteUsers($deletions)){
		$successes[] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
	}
	else {
		$errors[] = lang("SQL_ERROR");
	}
}

$userData = fetchAllUsers(); //Fetch information for all users

include_once("scripts/banner.php");
include_once("scripts/menubar.php");
echo "
<body>
<div id='top'></div></div>";

include("left-nav.php");

echo "
<div id='main'>
<h2>Admin Users</h2>";

echo resultBlock($errors,$successes);

echo "
<form name='adminUsers' action='".$_SERVER['PHP_SELF']."' method='post'>
<table class='admin'>
<tr>
<th>Delete</th><th>Username</th><th>Display Name</th><th>Title</th><th>Last Sign In</th>
</tr>";

//Cycle through users
foreach ($userData as $v1) {
	echo "
	<tr>
	<td><input type='checkbox' name='delete[".$v1['id']."]' id='delete[".$v1['id']."]' value='".$v1['id']."'></td>
	<td><a href='admin_user.php?id=".$v1['id']."'>".$v1['user_name']."</a></td>
	<td>".$v1['display_name']."</td>
	<td>".$v1['title']."</td>
	<td>
	";
	
	//Interprety last login
	if ($v1['last_sign_in_stamp'] == '0'){
		echo "Never";	
	}
	else {
		echo date("j M, Y", $v1['last_sign_in_stamp']);
	}
	echo "
	</td>
	</tr>";
}

echo "
</table>
<input type='submit' name='Submit' value='Delete' />
</form>
</div>
<div id='bottom'></div>
</body>
</html>";

?>
