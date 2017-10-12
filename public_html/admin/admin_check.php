<?php

function admin_check(){
	$expire = time() - 3600;
	$loc = "/~comp19900/admin";
	
	if (!empty($_COOKIE["super"])){
		$code = $_COOKIE["super"];
		if ($code != "61646d696e"){
			setcookie("super","null",time()-3600,"/~comp19900/admin");
			header("Location: http://deepblue.cs.camosun.bc.ca/~comp19900/admin/index");
			die();
		}
	}
	else {
		header("Location: http://deepblue.cs.camosun.bc.ca/~comp19900/admin/index");
		die();
	}
}

?>