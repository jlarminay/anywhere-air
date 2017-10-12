<?php
require "../library/template.php";
$conn = start();
?>
<html>
<head>
	<title>Anywhere Air</title>
	<link rel="icon" type="image/ico" href="images/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/blackrose_regular_macroman/stylesheet.css" />
	<link rel="stylesheet" type="text/css" href="fonts/nautilus/stylesheet.css" />
	
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
	<link rel="stylesheet" href="flag/flag.css" >
	<link rel="stylesheet" href="css/locations.css" >
	
	<script>
		<?php
		$query_con = "	SELECT name
						FROM location_continent";
		$query_cou = "	SELECT name
						FROM location_country";
		$query_cit = "	SELECT name
						FROM location_city";
		$result_con = mysqli_query($conn,$query_con);
		$result_cou = mysqli_query($conn,$query_cou);
		$result_cit = mysqli_query($conn,$query_cit);
		echo ("$(document).ready(function(){");
		if ($result_con){
			while($row_con = mysqli_fetch_row($result_con)) {
				$string = str_replace(' ','',$row_con[0]);
				echo ("$('#con_".$string."').click(function() {");
				echo ("$('#continent_".$string."').slideToggle('fast')");
				echo ("});");
			}
		}	
		if ($result_cou){
			while($row_cou = mysqli_fetch_row($result_cou)) {
				$string = str_replace(' ','',$row_cou[0]);
				echo ("$('#cou_".$string."').click(function() {");
				echo ("$('#country_".$string."').slideToggle('fast')");
				echo ("});");
			}
		}	
		echo ("});");
		?>
	</script>
	
</head>

<body>

	<div id="wall"></div>

	<div id="full">
	
		<?php
		header_print($conn);	
		?>
		
		<br/>	
		
		<div id="container clearfix">
			<div id="menu">
				
				<?php
				/*Start Continent Loop*/
				$query_con = "	SELECT 	LPAD(continent_id,2,'0'), name
								FROM location_continent";
				$result_con = 	mysqli_query($conn,$query_con);
				if ($result_con) {						
					while($row_con = mysqli_fetch_row($result_con)) {
						$string = str_replace(' ','',$row_con[1]);
						echo ("<div class='continent clearfix' id='con_".$string."'>".$row_con[1]."</div>");
						echo ("<div class='hide' id='continent_".$string."'>");
						/*Start Country Loop*/
						$query_cou = "	SELECT 	LPAD(country_id,3,'0'), name
										FROM location_country
										WHERE LPAD(continent_id,2,'0') = '".$row_con[0]."'";
						$result_cou = 	mysqli_query($conn,$query_cou);
						while($row_cou = mysqli_fetch_row($result_cou)) {
							$string = str_replace(' ','',$row_cou[1]);
							echo ("<div class='country clearfix' id='cou_".$string."'>");
							$cat = "f".$row_con[0]."-".$row_cou[0];
							echo ("<div class='flag ".$cat."'></div>");
							echo ("<p>".$row_cou[1]."</p>");
							echo ("</div>");
							echo ("<div class='hide' id='country_".$string."'>");
							/*Start Country Loop*/
							$query_cit = "	SELECT 	LPAD(city_id,3,'0'), name
											FROM location_city
											WHERE LPAD(country_id,3,'0') = '".$row_cou[0]."'";
							$result_cit = 	mysqli_query($conn,$query_cit);
							while($row_cit = mysqli_fetch_row($result_cit)) {
								$string = str_replace(' ','',$row_cit[1]);
								$code = $row_con[0]."-".$row_cou[0]."-".$row_cit[0];
								echo ("<a href='search?s=".$row_cit[1]."'><div class='city clearfix' id='".$string."'>".$row_cit[1]."</div></a>");
							}
							echo ("</div>");
						}
						echo ("</div>");
					}
				}
				else {
					echo ("nope");
				}
				?>
				
			</div>
		</div>
	</div>
</body>

<footer>
	<?php
	footer_print($conn);	
	?>
</footer>
</html>