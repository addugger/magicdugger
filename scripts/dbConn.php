<?php
try
{
	$dsn = "mysql:host=localhost;dbname=magicduggerdb";
	$usr = "magicdugger";
	$pass = "password";
	
	$conn = new PDO($dsn, $usr, $pass);
}
catch (Exception $e)
{
	echo $e -> getMessage();
}
?>