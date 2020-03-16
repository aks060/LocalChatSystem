<!DOCTYPE html>
<html>
<head>
<?php
require($_SERVER['DOCUMENT_ROOT'] . '/chat/include/include.php');

$js_start="<script type=\"text/javascript\">alert('";
$js_end="');</script>";

$error='';
if($_SERVER['REQUEST_METHOD']=="POST")
{
	if($_POST['formtype']=="login")
	{$uname=$_POST['user'];
	$pass=$_POST['pass'];
	$flag=1;
	if($uname=='' || $pass=='')
	{
		echo $js_start . 'Please Enter all the information in fields' . $js_end;
		$flag=0;
	}
	else
	{
		if(ctype_alnum($uname))
		{
			$q="SELECT * FROM user";
			$get_q=$conn->query($q);
			while($store_q=$get_q->fetch_assoc())
			{
				if($store_q['uname']==$uname)
				{
					if($store_q['admin_verify'])
					{if(password_verify($pass, $store_q['ukey']))
					{
						if(setsession($uname, $store_q['name'], $store_q['email']))
						echo $js_start . 'Login Success' . $js_end;
						header('Location:/chat');
						break;
					}
					else
					{
					echo $js_start . 'Sorry Wrong Credentials' . $js_end;
					$flag=0;
					}
					}
					else
					echo $js_start . 'You are not verified user' . $js_end;
					
				}
			}
			 
		}
		else
		{
			echo $js_start . 'Please enter a valid information' . $js_end;
			$flag=0;
		}
	}
	}
	
	else
	if($_POST['formtype']=="message")
	{
		$message=$_POST['message'];
		$query=$conn->prepare("INSERT INTO `mssg` (`name`, `uname`, `content`) VALUES ('" . $_SESSION['name'] . "', '" . $_SESSION['username'] . "', ?);");

		$query->bind_param("s", $message);
		$query->execute();
	}

	if($_POST['formtype']=="u")
	{
		//echo var_dump($_FILES);
		if(!empty($_FILES['file']['name'][0]))
		{
			//echo var_dump($_FILES);
		$file=$_FILES['file'];
		$maxsize=10000000;
		$type= ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
		if($file['size']<=$maxsize)
			{
				$filenamearray=explode('.', $file['name']);
				$fileformat=end($filenamearray);
				if(in_array($fileformat, $type))
				{
					$newname=$file['name'] . uniqid('', true) . '.' . $fileformat;
					$path=$_SERVER['DOCUMENT_ROOT'] . '/chat/media/' . $_SESSION['username'];
					$destination=$path . '/' . $newname;
					if(!is_dir($path))
					{
						mkdir($path, 0777, true);
							//echo 'Directory 1';
					}
					if(move_uploaded_file($file['tmp_name'], $destination))
					{
						$message="<a style=\"color:white\" target=\"_blank\" href=\"/chat/media/" . $_SESSION['username'] . '/' . $newname . '"><img src="/chat/media/' . $_SESSION['username'] . '/' . $newname . '" height="50px"></a>';
						$query="INSERT INTO `mssg` (`name`, `uname`, `content`) VALUES ('" . $_SESSION['name'] . "', '" . $_SESSION['username'] . "', '" . $message . "')";
		$insert_q=$conn->query($query);
					}

				}
				else
					$error="Only jpg, pdf, png and gif files are supported";
			}
			else
				$error="File is too long";
		}
		else
			$error="Please Select a file to upload";
	}
}

?>

<?php


function setsession($username, $name, $email)
	{
		setcookie('log', '1', 0, '/chat', null, null, true);
		$_SESSION['username']=$username;
		$_SESSION['log']='1';
		$_SESSION['name']=$name;
		$_SESSION['email']=$email;
		return 1;
	}

?>


<title>Personal Chat</title>
<?php
if($logedin)
{
?>
<style>
.message {
	width:100%;
	margin:auto;
	display:inline-block;
}

.message.cont {
	padding:3%;
	margin-top:80%;
}

.chat.cont.my {
	width:80%;
	height:auto;
	background-color:black;
	color:white;
	float:right;
	overflow: hidden;
    *zoom: 1;
}

.chat.cont {
	//margin-top:2%;
	width:80%;
	background-color:gray;
	height:auto;
	color:black;
	float:left;
	overflow: hidden;
    	*zoom: 1;
    	
}

.chat.message {
	float:left;
	padding-top:1%;
	font-size:25px;
}

.chat.message.my {
	float:right;
	padding-top:1%;
	font-size:20px;
}
</style>
<?php
}
?>
</head>
<body>
<?php
if($logedin==0)
{
?>
<h1 align="center"><u>Welcome to Oh! Yeah! CHAT</u></h1>
<center>
<div class="form_cont">
<form method="post">
<input type="text" name="user" placeholder="Enter username" required><br><br>
<input type="password" name="pass" placeholder="Enter password" required><br><br>
<input type="hidden" name="formtype" value="login">
<input type="submit" value="Login" name="login">
</form>
<br><br>OR<br><br>
<h2><a href="./signup">Sign Up here</a></h2>
</div>
</center>
<?php
}
else
{
//echo $logedin;
?>
<div class="cont">
<div class="chatbox cont">

<?php
/*$fetch_mssg="SELECT * FROM mssg ORDER BY time";
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
*/
?>
<iframe src="/chat/message" width="100%" height="100%" style="border:none;"></iframe>
<!--<br><br><br><br><br><br><br><br>-->
</div>
<div class="messagebox cont">
<form style="margin:auto;" method="post">
<input style="float:left; padding:none; font-size:medium; width:70%; height:auto" type="text" name="message" required>
<input type="hidden" name="formtype" value="message">
<input style="float:right; margin-right:40px;" type="submit" value="send">
</form>
<br><br><br>
<?php
if($error!='')
echo '<div style="color:red;">' . $error . '</div>';
?>
<br><br>
<form method="post" enctype="multipart/form-data">
<input type="file" name="file">
<input type="hidden" name="formtype" value="u">
<input type="submit" name="upload" value="upload">
</form>
<h2><a href="/chat/logout">Logout</a></h2>
</div>
</div>
<?php
}
?>



</body>
</html>
