<!DOCTYPE html>
<html>
<head>
<meta http-equiv="refresh" content="2">
<?php
require($_SERVER['DOCUMENT_ROOT'] . '/chat/include/include.php');
$fetch_mssg="SELECT * FROM mssg ORDER BY time DESC";
$get_message=$conn->query($fetch_mssg);
$store_mssg=$get_message->fetch_assoc();
$beep=0;
if(!isset($_COOKIE['update']))
{
	setcookie('update', $store_mssg['id']);
}
else
{
	if($_COOKIE['update']!=$store_mssg['id'])
	{
		if($store_mssg['uname']!=$_SESSION['username'])
			{
				$beep=1;
			}
		unset($_COOKIE['update']);
		setcookie('update', $store_mssg['id']);
	}
}
?>
</head>
<body>
<?php
if($beep)
{
?>
<audio autoplay>
	<source src="beep2.mp3" type="audio/mpeg">
</audio>
<?php
}
?>



<?php
if($logedin)
{
?>
<?php
$fetch_mssg="SELECT * FROM mssg ORDER BY time DESC";
$get_message=$conn->query($fetch_mssg);
while($store_mssg=$get_message->fetch_assoc())
{
$classcont='chat cont';
$classmsg='chat message';
$name=' ';
if($store_mssg['uname']==$_SESSION['username'])
{
	$classcont.=' my';
	$classmsg.=' my';
}
else
{
$name=$store_mssg['name'] . '::: ';
}
echo '<div class="' . $classcont . '"><div class="' . $classmsg . '">' . $name . $store_mssg['content'] . '</div></div>';
}
?>
<?php
}else
echo 'You are not authorise to access this page...';
?>
</body>
</html>
