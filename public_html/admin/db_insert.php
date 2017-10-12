<?php
require "admin_check.php";
admin_check();

require "../../library/connect.php";
$conn = server_connect();

echo ("<html style='text-align:center;'>");

if ($table = $_REQUEST['table']){
	$query = 	"SHOW COLUMNS FROM ".$table." where extra not like '%auto%'";
	$result =	mysqli_query($conn,$query);
	$result1 =	mysqli_query($conn,$query);
	if ($result){
		$rows = 	mysqli_num_rows($result);
		$fields = 	mysqli_num_fields($result);
		
		$final_query = "Insert into ".$table."(";
		
		$i = 0;
		while($col = mysqli_fetch_row($result)) {
			if ($i < $rows-1){
				if($choice = $_REQUEST[$col[0]]){
					$final_query .= "".$col[0].",";
				}
			}
			else {
				if($choice = $_REQUEST[$col[0]]){
					$final_query .= "".$col[0]."";
				}
			}
			$i ++;
		}
		$final_query .= ") values(";
		
		$i = 0;
		while($col = mysqli_fetch_row($result1)) {
			if ($i < $rows-1){
				if($choice = $_REQUEST[$col[0]]){
					$final_query .= "'".$choice."',";
				}
			}
			else {
				if($choice = $_REQUEST[$col[0]]){
					$final_query .= "'".$choice."'";
				}
			}
			$i ++;
		}
		$final_query .= ")";
	}
	$final_result = mysqli_query($conn,$final_query);
	if ($final_result){
		echo ("<p style='font-size:130%'>Insert Succeed</p>");
		echo ("<p style='font-size:100%'>Final Query:<br/>".$final_query."</p>");
	}
	else {
		echo ("<p style='font-size:130%'>Insert Failed</p>");
	}
}
else {
	header("Location: http://deepblue.cs.camosun.bc.ca/~comp19900/admin/db");
	die();
}

echo ("<br/>");
echo ("<a href='http://deepblue.cs.camosun.bc.ca/~comp19900/admin/db' style='font-size:130%'>Return</a>");
echo ("</html>");

?>