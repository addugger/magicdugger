<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $_GET['id'];

//Check if selected user exists
if(!userIdExists($userId)){
	header("Location: admin_users.php"); die();
}

$userdetails = fetchUserDetails(NULL, NULL, $userId); //Fetch user details
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
	//Delete selected account
	if(!empty($_POST['delete'])){
		$deletions = $_POST['delete'];
		if ($deletion_count = deleteUsers($deletions)) {
			$successes[] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
		}
		else {
			$errors[] = lang("SQL_ERROR");
		}
	}
	else
	{
		//Update display name
		if ($userdetails['display_name'] != $_POST['display']){
			$displayname = trim($_POST['display']);
			
			//Validate display name
			if(displayNameExists($displayname))
			{
				$errors[] = lang("ACCOUNT_DISPLAYNAME_IN_USE",array($displayname));
			}
			elseif(minMaxRange(5,25,$displayname))
			{
				$errors[] = lang("ACCOUNT_DISPLAY_CHAR_LIMIT",array(5,25));
			}
			elseif(!ctype_alnum($displayname)){
				$errors[] = lang("ACCOUNT_DISPLAY_INVALID_CHARACTERS");
			}
			else {
				if (updateDisplayName($userId, $displayname)){
					$successes[] = lang("ACCOUNT_DISPLAYNAME_UPDATED", array($displayname));
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
			
		}
		else {
			$displayname = $userdetails['display_name'];
		}
		
		//Activate account
		if(isset($_POST['activate']) && $_POST['activate'] == "activate"){
			if (setUserActive($userdetails['activation_token'])){
				$successes[] = lang("ACCOUNT_MANUALLY_ACTIVATED", array($displayname));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		//Update email
		if ($userdetails['email'] != $_POST['email']){
			$email = trim($_POST["email"]);
			
			//Validate email
			if(!isValidEmail($email))
			{
				$errors[] = lang("ACCOUNT_INVALID_EMAIL");
			}
			elseif(emailExists($email))
			{
				$errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));
			}
			else {
				if (updateEmail($userId, $email)){
					$successes[] = lang("ACCOUNT_EMAIL_UPDATED");
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
		}
		
		//Update title
		if ($userdetails['title'] != $_POST['title']){
			$title = trim($_POST['title']);
			
			//Validate title
			if(minMaxRange(1,50,$title))
			{
				$errors[] = lang("ACCOUNT_TITLE_CHAR_LIMIT",array(1,50));
			}
			else {
				if (updateTitle($userId, $title)){
					$successes[] = lang("ACCOUNT_TITLE_UPDATED", array ($displayname, $title));
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
		}
		
		//Remove permission level
		if(!empty($_POST['removePermission'])){
			$remove = $_POST['removePermission'];
			if ($deletion_count = removePermission($remove, $userId)){
				$successes[] = lang("ACCOUNT_PERMISSION_REMOVED", array ($deletion_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		if(!empty($_POST['addPermission'])){
			$add = $_POST['addPermission'];
			if ($addition_count = addPermission($add, $userId)){
				$successes[] = lang("ACCOUNT_PERMISSION_ADDED", array ($addition_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		$userdetails = fetchUserDetails(NULL, NULL, $userId);
	}
}

$userPermission = fetchUserPermissions($userId);
$permissionData = fetchAllPermissions();

include_once("scripts/banner.php");
include_once("scripts/menubar.php");

echo "
<body>
<div id='top'></div>";

include("left-nav.php");

echo "
<div id='main'>
<h2>Admin User</h2>";

echo resultBlock($errors,$successes);

echo "
<form name='adminUser' action='".$_SERVER['PHP_SELF']."?id=".$userId."' method='post'>
<table class='admin'><tr><td>
<h3>User Information</h3>
<div id='regbox'>
<table>
<tr>
<td>
<label>ID:</label>
</td>
<td>
".$userdetails['id']."
</td>
</tr>
<tr>
<td>
<label>Username:</label>
</td>
<td>
".$userdetails['user_name']."
</td>
</tr>
<tr>
<td>
<label>Display Name:</label>
</td>
<td>
<input type='text' name='display' value='".$userdetails['display_name']."' />
</td>
</tr>
<tr>
<td>
<label>Email:</label>
</td>
<td>
<input type='text' name='email' value='".$userdetails['email']."' />
</td>
</tr>
<tr>
<td>
<label>Active:</label>
</td>
<td>";

//Display activation link, if account inactive
if ($userdetails['active'] == '1'){
	echo "Yes";	
}
else{
	echo "No
	</p>
	<p>
	<label>Activate:</label>
	<input type='checkbox' name='activate' id='activate' value='activate'>
	";
}

echo "
</td>
</tr>
<tr>
<td>
<label>Title:</label>
</td>
<td>
<input type='text' name='title' value='".$userdetails['title']."' />
</td>
</tr>
<tr>
<td>
<label>Sign Up:</label>
</td>
<td>
".date("j M, Y", $userdetails['sign_up_stamp'])."
</td>
</tr>
<tr>
<td>
<label>Last Sign In:</label>
</td>
<td>";

//Last sign in, interpretation
if ($userdetails['last_sign_in_stamp'] == '0'){
	echo "Never";	
}
else {
	echo date("j M, Y", $userdetails['last_sign_in_stamp']);
}

echo "
</td>
</tr>
<tr>
<td>
<label>Delete:</label>
</td>
<td>
<input type='checkbox' name='delete[".$userdetails['id']."]' id='delete[".$userdetails['id']."]' value='".$userdetails['id']."'>
</td>
</tr>
<tr>
<td></td>
<td>
<input type='submit' value='Update' class='submit' />
</td>
</tr>
</table>
</div>
</td>
<td style='width: 0%; height: 100%; border-left: thin solid darkgray;'></td>
<td style='vertical-align:top;'>
<h3>Permission Membership</h3>
<div id='regbox'>
<p>Remove Permission:";

//List of permission levels user is apart of
foreach ($permissionData as $v1) {
	if(isset($userPermission[$v1['id']])){
		echo "<br><input type='checkbox' name='removePermission[".$v1['id']."]' id='removePermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name'];
	}
}

//List of permission levels user is not apart of
echo "</p><p>Add Permission:";
foreach ($permissionData as $v1) {
	if(!isset($userPermission[$v1['id']])){
		echo "<br><input type='checkbox' name='addPermission[".$v1['id']."]' id='addPermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name'];
	}
}

echo"
</p>
</div>
</td>
</tr>
</table>
</form>
</div>
<div id='bottom'></div>
</body>
</html>";

?>
