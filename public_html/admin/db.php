<?php
require "admin_check.php";
admin_check();
?>
<html style='text-align:center;'>
<a href='http://deepblue.cs.camosun.bc.ca/~comp19900/admin/home' style='font-size:130%'>Return</a>
<head>
	<title>Admin Page</title>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<style>
	.clearfix:after {
		content: "";
		display: table;
		clear: both;
	}
	.button:hover {
		background-color: grey;
	}
	#insert table input {
		padding: 5px;
		text-align:center;
		border: 0;
	}
	</style>
</head>

<body>
	<div id="container" class="clearfix" style="width:80%;margin:auto;border:1px solid black;">
		<p>Here we can edit the database, and such</p>
		<div id="results" style="float:left;width:30%;height:80%;border:1px solid black;" class="clearfix">
			<?php
			require "../../library/connect.php";
			$conn = server_connect();
			$query = "	show tables";

			$result = 	mysqli_query($conn,$query);
			$rows = 	mysqli_num_rows($result);
			$fields = 	mysqli_num_fields($result);

			//if results returned true
			if ($result) {
				echo ("<div id='tables' style='text-align:center;margin:auto;'>");
				echo ("<h2>Select a Table to View</h2>");
				echo ("<table border style='margin:auto;'>");
				
				while($row = mysqli_fetch_row($result)) {
					echo ("<tr>");
					foreach($row as $cell)
						echo ("<td style='padding:3px;'>$cell</td>");
						echo ("<td id='button_view_$cell' class='button' style='padding:3px;'>View</td>");
						echo ("<td id='button_edit_$cell' class='button' style='padding:3px;'>Edit</td>");
					echo ("</tr>");
					echo 	("
							<script>
							
							$('#button_view_$cell').click(function() {
								$('.table_hide').hide();
								$('#table_$cell').slideToggle('fast');
							});
							$('#button_edit_$cell').click(function() {
								$('.edit_hide').hide();
								$('#insert_form_$cell').slideToggle('fast');
								/*$('#update_form_$cell').slideToggle('fast');*/
								/*$('#delete_form_$cell').slideToggle('fast');*/
							});
					
							</script>
							");
							//COMMENTED OUT #delete_form_$cell and #update_form_$cell
				}
				echo ("</table>");
				echo ("</div>");
			}
			?>
		</div>
		<div id="query" style="text-align:center;border:1px solid black;float:right;width:69%;height:80%;overflow:auto;">
			<?php
			$query = "	show tables";

			$result = 	mysqli_query($conn,$query);
			$rows = 	mysqli_num_rows($result);
			$fields = 	mysqli_num_fields($result);

			//if results returned true
			if ($result){ 
				echo ("<h2>Selected Table</h2>");
				echo ("<div id='over'>");
				while($row = mysqli_fetch_row($result)) {
					$query1 = 	'select * from '.$row[0].'';
					$result1 =	mysqli_query($conn,$query1);
					if ($result1) {
						$rows = 	mysqli_num_rows($result1);
						$fields = 	mysqli_num_fields($result1);
						echo ("<table border id='table_".$row[0]."' class='table_hide' style='display:none;'>");
						echo ("<tr><td colspan><b><i>".$row[0]."</i></b></td></tr>");
						echo ("<tr>");
						for($i=0; $i<$fields; $i++) {
							$field = mysqli_fetch_field($result1);
							echo ("<td><b>{$field->name}</b></td>");
						}
						echo ("</tr>");
						
						while($col = mysqli_fetch_row($result1)) {
							echo ("<tr>");
							foreach($col as $cell)
								echo ("<td>$cell</td>");
							echo ("</tr>");
						}
						echo ("</table>");
					}
				}
				echo ("</div>");
			}
			?>
		</div>
	</div>
	<div id="insert" style="width:80%;border:1px solid black;margin:auto;text-align:center;" class="clearfix">
		<h2>Insert Into Table</h2>
		<p><b>!!!WARNING!!!</b><br/>IDs are auto-incrementing so they cannot be edited.
		<br/>If any information is of incorrect data type, the insert will fail.</p>
		<?php
		$query = "	show tables";

		$result = 	mysqli_query($conn,$query);
		$rows = 	mysqli_num_rows($result);
		$fields = 	mysqli_num_fields($result);
			
		//if results returned true
		if ($result){ 
			while($row = mysqli_fetch_row($result)) {
				$query1 = 	"SHOW COLUMNS FROM ".$row[0]." where extra not like '%auto%'";
				$result1 =	mysqli_query($conn,$query1);
				$result2 =	mysqli_query($conn,$query1);
				if ($result1) {
					echo ('<form id="insert_form_'.$row[0].'" method="post" action="db_insert.php" class="edit_hide" style="overflow:auto;display:none;">');
					echo ('<table border style="text-align:center;">');
					echo ("<tr><td colspan><b><input type='text' name='table' id='table' value='".$row[0]."' readonly></input></b></td></tr>");
					echo ("<tr>");
					while($col = mysqli_fetch_row($result1)) {
						echo ("<td><b>".$col[0]."</b></td>");
					}
					echo ("</tr>");
					echo ("<tr>");
					while($cul = mysqli_fetch_row($result2)) {
						echo ("<td><input type='text' id='".$cul[0]."' name='".$cul[0]."' placeholder='".$cul[0]."'></input></td>");
					}
					echo ("</tr>");
					echo ("</table>");
					echo ('<input type="submit" style="padding:10px;width:20%;"></input>');
					echo ('</form>');
				}
			}
		}
		?>
	</div>
	<div id="update" style="width:80%;border:1px solid black;margin:auto;text-align:center;">
		<h2><s>Update Table Data</s></h2>
		<p><b>!!!WARNING!!!</b><br/>If there is multiple rows with same data, they will all be edited.</p>
		<?php
		$query = "	show tables";

		$result = 	mysqli_query($conn,$query);
		$rows = 	mysqli_num_rows($result);
		$fields = 	mysqli_num_fields($result);
			
		//if results returned true
		if ($result){ 
			while($row = mysqli_fetch_row($result)) {
				$query1 = 	"select * from ".$row[0]."";
				$result1 =	mysqli_query($conn,$query1);
				$result2 =	mysqli_query($conn,$query1);
				if ($result1) {
					echo ('<form id="update_form_'.$row[0].'" method="post" action="db_update.php" class="edit_hide" style="overflow:auto;display:none;">');
					echo ('<table border style="text-align:center;">');
					echo ("<tr><td colspan><b><input type='text' name='table' id='table' value='".$row[0]."' readonly></input></b></td></tr>");
					echo ("<tr>");
					while($col = mysqli_fetch_row($result1)) {
						echo ("<td><b>".$col[0]."</b></td>");
					}
					echo ("</tr>");
					echo ("<tr>");
					while($cul = mysqli_fetch_row($result2)) {
						echo ("<td><input type='text' id='".$cul[0]."' name='".$cul[0]."' placeholder='".$cul[0]."'></input></td>");
					}
					echo ("</tr>");
					echo ("</table>");
					echo ('<input type="submit" style="padding:10px;width:20%;"></input>');
					echo ('</form>');
				}
			}
		}
		?>
	</div>
	<div id="delete" style="width:80%;border:1px solid black;margin:auto;text-align:center;">
		<h2><s>Delete Table Data</s></h2>
		<p><b>!!!WARNING!!!</b><br/>If there is multiple rows with same data, they will all be edited.
		<br/>Deletes cannot be undone.</p>
		<?php
		$query = "	show tables";

		$result = 	mysqli_query($conn,$query);
		$rows = 	mysqli_num_rows($result);
		$fields = 	mysqli_num_fields($result);

		//if results returned true
		if ($result){ 
			while($row = mysqli_fetch_row($result)) {
				$query1 = 	'select * from '.$row[0].'';
				$result1 =	mysqli_query($conn,$query1);
				
				if ($result1) {
					$rows1 = 	mysqli_num_rows($result1);
					$fields1 = 	mysqli_num_fields($result1);
					echo ('<form id="delete_form_'.$row[0].'" method="post" action="db_delete.php" class="edit_hide" style="overflow:auto;display:none;">');
					echo ('<table border style="text-align:center;">');
					echo ("<tr><td colspan><b><input type='text' name='table' id='table' value='".$row[0]."' readonly></input></b></td></tr>");
					echo ("<tr>");
					echo ("<td><b>Delete</b></td>");
					for($i=0; $i<$fields1; $i++) {
						$field1 = mysqli_fetch_field($result1);
						echo ("<td><b>{$field1->name}</b></td>");
					}
					echo ("</tr>");
					while($col = mysqli_fetch_row($result1)) {
						echo ("<tr>");
						//add proper value for pk
						echo ("<td><input type='checkbox' name='delete' value='".$culum[1]."'></input></td>");
						foreach($col as $cell)
							echo ("<td>$cell</td>");
						echo ("</tr>");
					}
					
					echo ("</table>");
					echo ('<input type="submit" style="padding:10px;width:20%;"></input>');
					echo ('</form>');
				}
			}
		}
		?>
	</div>
	<div id="raw" style="width:80%;border:1px solid black;margin:auto;text-align:center;">
		<h2>Raw MySQL Edit</h2>
		<p><b>!!!WARNING!!!</b>
		<br/>All changes final and cannot be undone. Only use this field if you know what your doing.</p>
		<form method='post' action='db_raw.php'>
			<b>Query Input:</b>
			<br/>
			<input type='text' id='query' name='query' placeholder='Query' style='width:100%;padding:7px;text-align:center;'></input>
			<br/>
			<b>Password</b>
			<br/>
			<input type='password' id='password' name='password' placeholder='Re-Enter Password' style='width:100%;padding:7px;text-align:center;'></input>
			<br/>
			<button style='width:20%;padding:7px;margin:10px 0 0 10px;'>Go</button>
		</form>
	</div>
</body>

<footer>
</footer>
</html>