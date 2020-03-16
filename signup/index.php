<!DOCTYPE html>
<html>
<head>
<?php
$js_start="<script type=\"text/javascript\">alert('";
$js_end="');</script>";
require($_SERVER['DOCUMENT_ROOT'] . '/chat/include/include.php');
?>
<title>
Signup for Ohh! Yeah!!
</title>
<?php
if($logedin)
{
	header('Location:/chat');
}

function emailcode($len)
{
	$a="ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz";
	$rand='';
	$lenga=strlen($a)-1;
	for($i=0; $i<$len; $i++)
	{
		$rand.=$a[rand(0, $lenga)];
	}
	return $rand;
}
?>

<script type="text/javascript">
function valid()
	{
		var name=document.getElementById('name').value;
		var email=document.getElementById('email').value;
		var user=document.getElementById('user').value;
		var pass=document.getElementById('pass').value;
		var repass=document.getElementById('repass').value;
		var form=document.getElementById('signup');
		if(name=='' || email=='' || user=='' || pass=='' || repass=='')
		{
		alert('Please Fill all the fields in the form');
		}
		else
		{
			if(pass==repass)
			{
				form.submit();	
			}
			else
			{
				alert('Password and re-password should same');
			}
		}
	}
</script>
</head>
<body>
<?php
if(!$logedin)
{
?>
	<h1 align="center"><u>Welcome to Ohh! Yeah!! Chat, Sign up here to continue</u></h1>
	<div class="form_cont">
	<center>
	<form method="post" name="signup" id="signup">
	Name:<br>
	<input type="text" name="name" id="name" placeholder="Enter Name here"><br>
	<br>E-Mail:<br>
	<input type="email" name="email" id="email" placeholder="Enter E-Mail here"><br>
	<br>Username:<br>
	<input type="text" name="user" id="user" placeholder="Enter Username"><br>
	<br>Password:</br>
	<input type="password" name="pass" id="pass" placeholder="Enter Password here"><br>
	<br>Repassword:</br>
	<input type="password" name="repass" id="repass" placeholder="Re-enter Password here"><br>
	<br><input type="button" value="Sign Up" onclick="valid()">
	</form></center>
	</div>
<?php
}
?>

<?php
if($_SERVER['REQUEST_METHOD']=="POST")
{
	$name=$_POST['name'];
	$email=$_POST['email'];
	$user=$_POST['user'];
	$pass=$_POST['pass'];
	$repass=$_POST['repass'];
	$flag=1;
	$name_flag=0;
	if($name=='' || $email=='' || $user==''||$pass==''||$repass=='')
	{
		echo $js_start . "Please Fill all the fields in the form" . $js_end;
		$flag=0;
	}
	else
	{
		//echo '1';
		if($pass!=$repass)
		{
			echo $js_start . "Password and re-password should same" . $js_end;
			$flag=0;
		}
		else
		{
			for($i=0; $i<strlen($name); $i++)
			{
				if(ctype_alpha($name[$i]) || $name[$i]==' ')
				{
					$name_flag=1;
				}
				else
				{
					$name_flag=0;
					break;
				}
			}
			
			if($name_flag)
			{
				if(ctype_alnum($user))
				{
					//echo '2';
					$emailuniq=1;
					$useruniq=1;
					$getres="SELECT * FROM user";
					$get_res=$conn->query($getres);
					//echo '3';
					while($store_res=$get_res->fetch_assoc())
					{
						if($user==$store_res['uname'])
						{
							//echo '4';
							$useruniq=0;
							break;
							
						}
						else
						{
							//echo '5';
							$useruniq=1;							
						}
						if($email==$store_res['email'])
						{
							$emailuniq=0;
							break;
						}
						else
						{
							$emailuniq=1;
						}
					}
					if($useruniq && $emailuniq)
					{
						//echo '3';
						$email_code=emailcode(6);
					$hash=password_hash($_POST["pass"], PASSWORD_BCRYPT, array('cost' => 12));
					$insert="INSERT INTO `user` (`uname`, `name`, `email`, `ukey`, `email_code`) VALUES ('" . $user . "', '" . $name . "', '" . $email . "', '" . $hash . "', '" . $email_code . "')";
					if($get_insert=$conn->query($insert))
					{
						echo $js_start . "You are successfully registered, Please login to continue" . $js_end;					
						header('Location:/chat');	
					}
					else
					{
						echo $js_start . "Sorry, Something is wrong" . $js_end;
					}
					}
					
					else
					if($useruniq)
					{
						echo $js_start . "Email already registered with us, Please Login to continue" . $js_end;
					}
					else
					if($emailuniq)
					{
						echo $js_start . "Username already exit, please try something else" . $js_end;
					}
				}
				else
				{
					echo $js_start . "Username can only contain alpha-numeric character" . $js_end;
				}
			}
			else
			{
				echo $js_start . "Name should contain only Alphabets" . $js_end;
			}
		}
	}
}
?>
</body>
</html>
