<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

if (!securePage($_SERVER['PHP_SELF'])){die();}

//styling
echo "
<style>
		#left-nav {
			font-family: Impact, Charcoal, sans-serif;
		}
		
		#left-nav ul {
			list-style-type: none;
			padding-left: 20px;
			padding-right: 40px;
			width: 140px;
		}
		#left-nav li {
			background-color: lightyellow;
			padding: 3px;
			margin: 3px;
			text-align: center;
		}
		#left-nav a {
			text-decoration: none;
			color: rgb(126, 126, 126);
		}
</style>";

echo "
	<div id='left-nav' style='float:left'>";

//Links for logged in user
if(isUserLoggedIn()) {
	echo "
	<ul>
	<li><a href='account.php'>Account Home</a></li>
	<li><a href='user_settings.php'>User Settings</a></li>
	<li><a href='logout.php'>Logout</a></li>
	</ul>";
	
	//Links for permission level 2 (default admin)
	if ($loggedInUser->checkPermission(array(2))){
	echo "
	<ul>
	<li>Admin Links</li>
	<li><a href='admin_configuration.php'>Admin Configuration</a></li>
	<li><a href='admin_users.php'>Admin Users</a></li>
	<li><a href='admin_permissions.php'>Admin Permissions</a></li>
	<li><a href='admin_pages.php'>Admin Pages</a></li>
	</ul>";
	}
} 
//Links for users not logged in
else {
	echo "
	<ul>
	<li><a href='index.php'>Home</a></li>
	<li><a href='login.php'>Login</a></li>
	<li><a href='register.php'>Create Account</a></li>
	<li><a href='forgot-password.php'>Forgot Password</a></li>";
	echo "</ul>";
}

echo "
	</div>"

?>
