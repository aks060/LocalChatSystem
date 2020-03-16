<?php
header('Content-type:text/css');
include($_SERVER['DOCUMENT_ROOT'] . '/chat/include/auth.php');
?>
h1 {
	font-size:40px;
	font-family:Arial;
}

input[type="text"], input[type="password"], input[type="email"] {
	width:80%;
	height:30px;
	font-size:larger;
	padding-left:2%;
	padding-right:2%;
}

.form_cont {
	width:50%;
	margin:auto;
}

input[type="submit"], input[type="button"] {
	font-size:large;
	padding:2%;
	cursor:pointer;
	border:none;
	background-color:black;
	color:white
	
}

input[type="submit"]:hover {
	background-color:red;
	color:black;
	border:none;
}

a {
	text-decoration:none;
	color:black;
	cursor:pointer;
}

a:hover {
	color:red;
}

.error {
	color:red;
	font-weight:strong;
	font-size:20px;
}

<?php
if($logedin)
{
?>
.cont {
	width:70%;
	margin:auto;
	color:black;
	overflow: hidden;
    *zoom: 1;
}

.chatbox.cont {
	width:70%;
	height:500px;
	margin:auto;
	border:solid 1px black;
}

.messageboc.cont {
	width:70%;
	height:500px;
	margin:auto;
}

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
<?php
}
?>
