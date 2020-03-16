<?php
session_start();
session_destroy();
unset($_COOKIE['log']);
setcookie('log', '', time() - 3600);
header('Location:/chat');
?>
