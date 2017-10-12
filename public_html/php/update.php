<?php

require "../../library/connect.php";
$conn = server_connect();
$loc = "/~comp19900/";
//-------------------------------------------------------
//REGEX
$reg_email = 	('/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i');
$reg_address = 	('/^[a-zA-Z0-9-\/] ?([a-zA-Z0-9-\/]|[a-zA-Z0-9-\/] )*[a-zA-Z0-9-\/]$/');
$reg_city =		('/^[a-zA-z] ?([a-zA-z]|[a-zA-z] )*[a-zA-z]$/');
$reg_state =	('/^[a-zA-z] ?([a-zA-z]|[a-zA-z] )*[a-zA-z]$/');
$reg_country =	('/^[a-zA-z] ?([a-zA-z]|[a-zA-z] )*[a-zA-z]$/');
$reg_zip_us =	('/(^\d{5}$)|(^\d{5}-\d{4}$)/');
$reg_zip_can =	('/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/');
$reg_phone =	('/^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/');





//-------------------------------------------------------
if (!empty($_REQUEST['name_first'])){
	$first_name = $_REQUEST['name_first'];
}
else {
	$first_name = NULL;
}
if (!empty($_REQUEST['name_last'])){
	$last_name = $_REQUEST['name_last'];
}
else {
	$last_name = NULL;
}
if (!empty($_REQUEST['username'])){
	$username =	$_REQUEST['username'];
	$username = NULL;
}
else {
	$username = NULL;
}
//-------------------------------------------------------
if (!empty($_REQUEST['new_pass'])){
	$new_pass =	$_REQUEST['new_pass'];
}
else {
	$new_pass = NULL;
}
if (!empty($_REQUEST['new_pass_confirm'])){
	$new_pass_confirm =	$_REQUEST['new_pass_confirm'];
}
else {
	$new_pass_confirm = NULL;
}
if ($new_pass != $new_pass_confirm){
	setcookie('error','3',time()+60,$loc);
	header("Location: http://joshlarminay.com/projects/anywhere_air/public_html/user");
	die();
}
//-------------------------------------------------------
if (!empty($_REQUEST['email'])){
	$email = $_REQUEST['email'];
	if(preg_match($reg_email,$email,$email_array)){
		$email = $email_array[0];
	}
	else {
		setcookie('error','8',time()+60,$loc);
		header("Location: http://joshlarminay.com/projects/anywhere_air/public_html/user");
		die();
	}
}
else {
	$email = NULL;
}
//-------------------------------------------------------
if (!empty($_REQUEST['bd_year'])){
	$bd_year =	$_REQUEST['bd_year'];
}
else {
	$bd_year = NULL;
}
//------------------------------
if (!empty($_REQUEST['bd_month'])){
	$bd_month =	$_REQUEST['bd_month'];
}
else {
	$bd_month = NULL;
}
//------------------------------
if (!empty($_REQUEST['bd_day'])){
	$bd_day =	$_REQUEST['bd_day'];
}
else {
	$bd_day = NULL;
}
//-------------------------------------------------------
if (!empty($_REQUEST['address'])){
	$address =	$_REQUEST['address'];
	if(preg_match($reg_address,$address,$address_array)){
		$address = $address_array[0];
	}
	else {
		setcookie('error','8',time()+60,$loc);
		header("Location: http://joshlarminay.com/projects/anywhere_air/public_html/user");
		die();
	}
}
else {
	$address = NULL;
}
//------------------------------
if (!empty($_REQUEST['phone'])){
	$phone =	$_REQUEST['phone'];
	if(preg_match($reg_phone,$phone,$phone_array)){
		$phone = $phone_array[0];
	}
	else {
		setcookie('error','8',time()+60,$loc);
		header("Location: http://joshlarminay.com/projects/anywhere_air/public_html/user");
		die();
	}
}
else {
	$phone = NULL;
}
//------------------------------
if (!empty($_REQUEST['zip'])){
	$zip =	$_REQUEST['zip'];
	if(preg_match($reg_zip_can,$zip,$zip_array)){
		$zip = $zip_array[0];
	}
	else {
		setcookie('error','8',time()+60,$loc);
		header("Location: http://joshlarminay.com/projects/anywhere_air/public_html/user");
		die();
	}
}
else {
	$zip = NULL;
}
//------------------------------
if (!empty($_REQUEST['city'])){
	$city =	$_REQUEST['city'];
	if(preg_match($reg_city,$city,$city_array)){
		$city = $city_array[0];
	}
	else {
		setcookie('error','8',time()+60,$loc);
		header("Location: http://joshlarminay.com/projects/anywhere_air/public_html/user");
		die();
	}
}
else {
	$city = NULL;
}
//------------------------------
if (!empty($_REQUEST['state'])){
	$state =	$_REQUEST['state'];
	if(preg_match($reg_state,$state,$state_array)){
		$state = $state_array[0];
	}
	else {
		setcookie('error','8',time()+60,$loc);
		header("Location: http://joshlarminay.com/projects/anywhere_air/public_html/user");
		die();
	}
}
else {
	$state = NULL;
}
//------------------------------
if (!empty($_REQUEST['country'])){
	$country =	$_REQUEST['country'];
	if(preg_match($reg_country,$country,$country_array)){
		$country = $country_array[0];
	}
	else {
		setcookie('error','8',time()+60,$loc);
		header("Location: http://joshlarminay.com/projects/anywhere_air/public_html/user");
		die();
	}
}
else {
	$country = NULL;
}
//-------------------------------------------------------
if (!empty($_REQUEST['master_pass'])){
	$master_pass =	$_REQUEST['master_pass'];
}
else{
	setcookie('error','1',time()+60,$loc);
	header("Location: http://joshlarminay.com/projects/anywhere_air/public_html/user");
	die();
}
//-------------------------------------------------------
if ((!empty($_REQUEST['bd_day'])) and (!empty($_REQUEST['bd_day'])) and (!empty($_REQUEST['bd_day']))){
	$birth_day = $bd_year . "-" . $bd_month . "-" . $bd_day;
}
else {
	$birth_day = NULL;
}

$array = explode('-',$_COOKIE['user']);
$id = $array[0];

$query = "	select * 
			from users 
			where user_id = '".$id."'
			and password = '".$master_pass."'";
$result = mysqli_query($conn, $query);

if ($result){
	$rows = mysqli_num_rows($result);
	$fields = mysqli_num_fields($result);
	if ($rows > 0){
		$i = 0;
		$query = "	update users set ";
		if ($last_name != NULL){
			if ($i > 0){
				$query .= ",";
			}
			$query .= " name_last = '".$last_name."'";
			$i++;
		}
		if ($first_name != NULL){
			if ($i > 0){
				$query .= ",";
			}
			$query .= " name_first = '".$first_name."'";
			$i++;
		}
		if ($username != NULL){
			if ($i > 0){
				$query .= ",";
			}
			$query .= " username = '".$username."'";
			$i++;
		}
		if ($email != NULL){
			if ($i > 0){
				$query .= ",";
			}
			$query .= " email = '".$email."'";
			$i++;
		}
		if ($address != NULL){
			if ($i > 0){
				$query .= ",";
			}
			$query .= " address = '".$address."'";
			$i++;
		}
		if ($phone != NULL){
			if ($i > 0){
				$query .= ",";
			}
			$query .= " phone = '".$phone."'";
			$i++;
		}
		if ($zip != NULL){
			if ($i > 0){
				$query .= ",";
			}
			$query .= " zip = '".$zip."'";
			$i++;
		}
		if ($city != NULL){
			if ($i > 0){
				$query .= ",";
			}
			$query .= " city = '".$city."'";
			$i++;
		}
		if ($state != NULL){
			if ($i > 0){
				$query .= ",";
			}
			$query .= " state = '".$state."'";
			$i++;
		}
		if ($country != NULL){
			if ($i > 0){
				$query .= ",";
			}
			$query .= " country = '".$country."'";
			$i++;
		}
		if ($birth_day != NULL){
			if ($i > 0){
				$query .= ",";
			}
			$query .= " birth_day = '".$birth_day."'";
			$i++;
		}
		if ($new_pass != NULL){
			if ($i > 0){
				$query .= ",";
			}
			$query .= " password = '".$new_pass."'";
			$i++;
		}
		
		$query .=	"where user_id = '".$id."'
					and password = '".$master_pass."'";
		$result = mysqli_query($conn, $query);
		if ($result = True){
			header("Location: http://joshlarminay.com/projects/anywhere_air/public_html/user");
			die();
		}
		else {
			setcookie('error','2',time()+60,$loc);
			header("Location: http://joshlarminay.com/projects/anywhere_air/public_html/user");
			die();
		}
	}
	else {
		setcookie('error','7',time()+60,$loc);
		header("Location: http://joshlarminay.com/projects/anywhere_air/public_html/user");
		die();
	}
}
else {
	setcookie('error','2',time()+60,$loc);
	header("Location: http://joshlarminay.com/projects/anywhere_air/public_html/user");
	die();
}