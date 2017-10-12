<?php
session_start();
require "../../library/connect.php";
$conn = server_connect();

$expire = time() - 3600;
$loc = "/";

$array = explode("-",$_COOKIE["user"]);

$query = "	delete from sessions
			where user_id = '".$array[0]."'";

$result = mysqli_query($conn,$query);

setcookie("uname","null",$expire,$loc);
setcookie("user","null",$expire,$loc);
unset($_SESSION['cart']);

header("Location: ../index.php");
die();

?>