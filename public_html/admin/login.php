<?php

$username = $_REQUEST['user'];
$password = $_REQUEST['pass'];

if (empty($username)){
	die ("Username Empty");
}
if (empty($password)){
	die ("Password Empty");
}

require "admin_get.php";

$act_user = getUser();
$act_pass = getPass();

if ($username == $act_user){
	if ($password == $act_pass){
		setcookie("super","61646d696e",time()+3600,"");
		header("Location: home");
		die();
	}
	else {
		die ("Password Wrong");
	}
}
else {
	die ("Username Wrong");
}


?>