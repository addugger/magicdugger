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
			margin-top: 30px;
			height: 1500px;
		}
		
		#left-nav ul {
			list-style-type: none;
			padding-left: 10px;
			padding-right: 50px;
			width: 140px;
		}
		#left-nav li {
			background-color: lightyellow;
			margin: 3px;
			text-align: center;
		}
		#left-nav a {
			text-decoration: none;
			color: #7E7E7E;
			display: block;
			padding: 3px;
		}
		#left-nav a:hover {
			background-color: #B4ADAD;
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
	<li><a href='login.php'>Login</a></li>
	<li><a href='register.php'>Create Account</a></li>
	<li><a href='forgot-password.php'>Forgot Password</a></li>";
	echo "</ul>";
}

echo "
	</div>"

?>
