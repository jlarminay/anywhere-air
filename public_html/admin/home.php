<?php
require "admin_check.php";
admin_check();
?>
<html>
<head>
	<title>Admin Home</title>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	
	<style>
	.clearfix:after {
		content: "";
		display: table;
		clear: both;
	}
	#container {
		width: 80%;
		margin: auto;
		text-align: center;
	}
	#info {
		width: 49%;
		float: left;
	}
	#table {
		width: 49%;
		float: right;
	}
	#option {
		width: 80%;
		margin: auto;
		text-align: center;
	}
	.next {
		border: 1px solid black;
		padding: 20px;
		width: 40%;
		text-align: center;
		margin: 5px auto 5px auto;
		text-decoration: none;
	}
	.next:hover {
		background-color: grey;
	}
	</style>
</head>

<body>
	<div id="container" class="clearfix" style="border:1px solid black;">
		<h1>Admin Home Page</h1>
		<div id="info">
			<?php
			require "../../library/connect.php";
			$conn = server_connect();
			
			echo ("<h3>Server Info</h3>");
			echo ("<table>");
			echo ("	<tr>");
			echo ("		<td><b>Host name: </b></td>");
			echo ("		<td>".php_uname('n')."</td>");
			echo ("	</tr>");
			
			echo ("	<tr>");
			echo ("		<td><b>Operating System: </b></td>");
			echo ("		<td>".php_uname('s')."</td>");
			echo ("	</tr>");
			
			echo ("	<tr>");
			echo ("		<td><b>PHP version: </b></td>");
			echo ("		<td>".phpversion()."</td>");
			echo ("	</tr>");
			
			echo ("	<tr>");
			echo ("		<td><b>PHP connection: </b></td>");
			echo ("		<td>".php_sapi_name()."</td>");
			echo ("	</tr>");
			
			echo ("	<tr>");
			echo ("		<td><b>MySQL version: </b></td>");
			echo ("		<td>".mysqli_get_server_info($conn)."</td>");
			echo ("	</tr>");
			
			echo ("	<tr>");
			echo ("		<td><b>MySQL connection: </b></td>");
			echo ("		<td>".mysqli_get_host_info($conn)."</td>");
			echo ("	</tr>");
			
			echo ("	<tr>");
			echo ("		<td><b>Current memory usage: </b></td>");
			echo ("		<td>".memory_get_usage()." bytes</td>");
			echo ("	</tr>");
			
			echo ("	<tr>");
			echo ("		<td><b>Peak memory usage: </b></td>");
			echo ("		<td>".memory_get_peak_usage(True)." bytes</td>");
			echo ("	</tr>");
			
			echo ("</table>");
			?>
		</div>
		<div id="table">
			<?php
			$query = "	show tables";

			$result = 	mysqli_query($conn,$query);
			$rows = 	mysqli_num_rows($result);
			$fields = 	mysqli_num_fields($result);

			//if results returned true
			if ($result) {
				echo ("<h3>Number of Items in tables</h3>");
				echo ("<table>");
				while($row = mysqli_fetch_row($result)) {
					$query1 = 	'select count(*) from '.$row[0].'';
					$result1 =	mysqli_query($conn,$query1);
					if ($result1) {
						echo ("<tr>");
						while($col = mysqli_fetch_row($result1)) {
							echo ('<td><b>'.$row[0].': </b></td>');
							echo ('<td>'.$col[0].'</td>');
						}
						echo ("</tr>");
					}
				}
				echo ("</table>");
			}
			?>
		</div>
	</div>
	<div id="option" style="border:1px solid black;">
		<a href="adminer"><div class="next">Edit Database</div></a>
		<a href="front"><div class="next">Edit Front Slider</div></a>
	</div>
</body>

<footer>
</footer>
</html>