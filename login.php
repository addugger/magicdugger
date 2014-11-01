<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) { 
	//attempt to reroute to page that originally sent the person
	//to the login page
	if (isset($_POST["referer"]))
	{
		header("Location: $_POST[referer]");
	}
	else
	{
		header("Location: account.php");
	}
	die();
}
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
	$errors = array();
	$username = sanitize(trim($_POST["username"]));
	$password = trim($_POST["password"]);
	
	//Perform some validation
	//Feel free to edit / change as required
	if($username == "")
	{
		$errors[] = lang("ACCOUNT_SPECIFY_USERNAME");
	}
	if($password == "")
	{
		$errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
	}

	if(count($errors) == 0)
	{
		//A security note here, never tell the user which credential was incorrect
		if(!usernameExists($username))
		{
			$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
		}
		else
		{
			$userdetails = fetchUserDetails($username);
			//See if the user's account is activated
			if($userdetails["active"]==0)
			{
				$errors[] = lang("ACCOUNT_INACTIVE");
			}
			else
			{
				//Hash the password and use the salt from the database to compare the password.
				$entered_pass = generateHash($password,$userdetails["password"]);
				
				if($entered_pass != $userdetails["password"])
				{
					//Again, we know the password is at fault here, but lets not give away the combination incase of someone bruteforcing
					$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
				}
				else
				{
					//Passwords match! we're good to go'
					
					//Construct a new logged in user object
					//Transfer some db data to the session object
					$loggedInUser = new loggedInUser();
					$loggedInUser->email = $userdetails["email"];
					$loggedInUser->user_id = $userdetails["id"];
					$loggedInUser->hash_pw = $userdetails["password"];
					$loggedInUser->title = $userdetails["title"];
					$loggedInUser->displayname = $userdetails["display_name"];
					$loggedInUser->username = $userdetails["user_name"];
					
					//Update last sign in
					$loggedInUser->updateLastSignIn();
					$_SESSION["userCakeUser"] = $loggedInUser;
					
					//attempt to reroute to page that originally sent the person
					//to the login page. else, redirect to user account page
					if (isset($_POST["referer"]))
					{
						header("Location: $_REQUEST[referer]");
					}
					else
					{
						header("Location: account.php");
					}
					die();
				}
			}
		}
	}
}

include_once("scripts/banner.php");
include_once("scripts/menubar.php");
echo "
<body>
<div id='wrapper'>
<div id='top'></div>";
							
include("left-nav.php");

echo "
<div id='main'>
<h2>Login</h2>";

echo resultBlock($errors,$successes);

echo "
<div id='regbox'>
<form name='login' action='".$_SERVER['PHP_SELF']."' method='post'>";
if (isset($_REQUEST["referer"]))
{
	echo("<input type='hidden' name='referer' value='$_REQUEST[referer]'>");
}
echo "
<table>
<tr>
<td>
<label>Username:</label>
</td>
<td>
<input type='text' name='username' />
</td>
</tr>
<tr>
<td>
<label>Password:</label>
</td>
<td>
<input type='password' name='password' />
</td>
</tr>
<tr>
<td></td>
<td>
<input type='submit' value='Login' class='submit' />
</td>
</tr>
</table>
</form>
</div>
</div>
<div id='bottom'></div>
</div>
</body>
</html>";

?>
