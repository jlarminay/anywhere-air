<?php

require "../../library/connect.php";

$conn = server_connect();

$min = 0;
$max = 1000000000000;
$time = time() + 360000;
$loc = "/";

$username = 	$_REQUEST['user'	];
$password = 	$_REQUEST['pass'	];
$hashpass = 	$password;

$query = "	select user_id, username
			from users
			where lower(username) = lower('".$username."')
			and password = '".$hashpass."'";
			
$result = mysqli_query($conn,$query);

if ($result){
	$row = mysqli_num_rows($result);
	if ($row > 0){
		
		while($row = mysqli_fetch_row($result)) {
			$uid = 		$row[0];
			$session =	rand($min,$max);
			$key =		rand($min,$max);
			$user = 	$row[1];
		}
		
		//last joinded
		$today = getdate();
		$date = $today['year']."-".$today['mon']."-".$today['mday'];
		$query = "	update users
					set date_last = '".$date."'
					where user_id = '".$uid."'";			
		$result = mysqli_query($conn,$query);
		
		//session
		$query = "	insert into sessions(session_id,user_id,key_id)
					values('".$session."','".$uid."','".$key."')";			
		$result = mysqli_query($conn,$query);
		$query = "	update sessions
					set session_id = '".$session."', key_id = '".$key."'
					where user_id = '".$uid."'";			
		$result = mysqli_query($conn,$query);
		
		$string = $uid."-".$session."-".$key;
		setcookie('user',$string,$time,$loc);
		setcookie('uname',$user,$time,$loc);
		
		
		require "usrCart.php";
		mergeCart($uid,$conn);
		

		//send back
		header("Location: ../index.php");
		die();
		
	}
	else {
		setcookie('error','1',time()+60,$loc);
		header("Location: http://joshlarminay.com/projects/anywhere_air/public_html/login");
		die();
	}
}
else{
	setcookie('error','2',time()+60,$loc);
	header("Location: http://joshlarminay.com/projects/anywhere_air/public_html/login");
	die();
}


?>