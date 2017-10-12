<?php
require "admin_check.php";
admin_check();

echo ("<html style='text-align:center'>");

if (!empty($_POST['query'])){
	$query = $_POST['query'];
	$pass = $_POST['password'];
	
	require "admin_get.php";
	require "../../library/connect.php";
	$conn = server_connect();
	$act_pass = getPass();
	
	if ($pass == $act_pass){
		$result = 	mysqli_query($conn,$query);

		//if results returned true
		if ($result) {
			if (is_bool($result) === false){
				$fields = mysqli_num_fields($result);
				echo ("<h1>".$query."</h1>");
				echo ("<table border style='margin:auto'>");
				
				echo ("<tr>");
				for($i=0; $i<$fields; $i++) {
					$field = mysqli_fetch_field($result);
					echo ("<td><b>{$field->name}</b></td>");
				}
				echo ("</tr>");
				
				while($row = mysqli_fetch_row($result)) {
					echo ("<tr>");
					foreach($row as $cell)
						echo ("<td>$cell</td>");
					echo ("</tr>");
				}
				echo ("</table>");
			}
			else {
				echo ("<h1>".$query."</h1>");
				echo ("<p style='font-size:130%'>Query Successful</p>");
			}
		}
		//if no results
		else {
			echo ("<h1>".$query."</h1>");
			echo ("<p style='font-size:130%'>Query Failed</p>");
		}
	}
}

echo ("<br/>");
echo ("<a href='http://deepblue.cs.camosun.bc.ca/~comp19900/admin/db' style='font-size:130%'>Return</a>");
echo ("<html>");

?>