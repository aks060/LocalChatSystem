<?php
$conn=mysqli_connect("localhost", "user", "password", "db");
if(mysqli_connect_errno())
{
	die('Sorry, Can\'t connect to the database');
	exit();
}
?>
