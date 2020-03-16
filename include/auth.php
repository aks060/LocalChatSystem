<?php
session_start();
$logedin=0;
$user=0;
if(isset($_COOKIE['log']) && isset($_SESSION['username']) && $_COOKIE['log']=='1' && $_SESSION['log']=='1')
{
	$logedin=1;
	$user=1;
}
else
{
	$logedin=0;
	$user=0;
	//session_destroy();
}
?>
