<?php
require "../library/template.php";
require "../library/slider.php";
//$conn = server_connect();
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
	
	<script src="js.bxslider/jquery.bxslider.min.js"></script>
	<link rel="stylesheet" type="text/css" href="js.bxslider/jquery.bxslider.css" />
	
	<script src="js.bowser/bowser.js"></script>
	<script src="js.bowser/popup.js"></script>
	<link rel="stylesheet" type="text/css" href="js.bowser/popup.css" />
	
	<script>
		$(document).ready(function(){
			/*--Main Slider--*/
			$('.slider_main').bxSlider({
				auto: true,
				speed: 1000,
				pause: 5000
			});
			/*--Mini Slider--*/
			$('.slider_pop').bxSlider({
				slideWidth: 300,
				minSlides: 1,
				maxSlides: 4,
				slideMargin: 10,
			});
		});	
	</script>
	
</head>

<body>

	<div id="popup">
		<div id="view">
			<h3>Welcome To Anywhere Air</h3>
			<p>The browser you are using is not supported so some features may load differently.</p>
			<p>We recommend upgrading browsers for the best support.</p>
			
			<button id="end">Enter</button>
		</div>
	</div>

	<div id="wall"></div>

	<div id="full">
	
		<?php
		header_print($conn);	
		?>
		
		<br/>	
		
		<div id="container">
			<!----- Slider Start ----->
			<ul class="slider_main">
				<?php
				slider_regx_print();
				?>
			</ul>
			<!----- Slider End ----->
			<br/>
			<hr>
			<br/>
			<!--------------------------------------------------MOST POPULAR-------------------------------------------------->
			<div id="popular">
				<h2>Most Popular Items</h2>
				<!----- Slider Start ----->
				<ul class="slider_pop" style="padding-bottom:20px;">
					<?php
					$query = "	SELECT 	i.item_id, i.date_last_sold,
										LPAD(i.continent_id,2,'0'),
										LPAD(i.country_id,3,'0'),
										LPAD(i.city_id,3,'0'),
										cit.name, i.total_sold
								FROM item i, location_city cit
								where i.city_id = cit.city_id
								order by i.total_sold DESC
								LIMIT 10";
					
					$result = 	mysqli_query($conn,$query);
					if ($result) {						
						while($row = mysqli_fetch_row($result)) {
							$loc = $row[2] . "-" . $row[3] . "-" . $row[4];
							echo ("<li class='slide'><a href='product?id=".$row[0]."'>");
							echo ("	<div class='placer'>");
							echo ("		<img src='images/cities/". $loc .".jpg' title='". $row[5] ."' alt='' style='position:relative;float:left;'></img>");
							echo ("		<p style='color:#684684;background-color:#aeaeae;position:absolute;width:100%;padding:3% 0 3% 0;margin-top:50%;'>".$row[5]."</p>");
							echo ("	</div>");
							echo ("</a></li>");
						}
					}
					?>
				</ul>
				<!----- Slider End ----->
			</div>
			<br/>
			<hr>
			<br/>
			<!--------------------------------------------------NEW ITEMS-------------------------------------------------->
			<div id="popular">
				<h2>Newest Items</h2>
				<!----- Slider Start ----->
				<ul class="slider_pop" style="padding-bottom:20px;">
					<?php
					$query = "	SELECT 	i.item_id, i.date_last_sold,
										LPAD(i.continent_id,2,'0'),
										LPAD(i.country_id,3,'0'),
										LPAD(i.city_id,3,'0'),
										cit.name, i.date_added
								FROM item i, location_city cit
								where i.city_id = cit.city_id
								order by i.date_added DESC
								LIMIT 10";
					
					$result = 	mysqli_query($conn,$query);
					if ($result) {						
						while($row = mysqli_fetch_array($result)) {
							$loc = $row[2] . "-" . $row[3] . "-" . $row[4];
							echo ("<li class='slide'><a href='product?id=".$row[0]."'>");
							echo ("	<div class='placer'>");
							echo ("		<img src='images/cities/". $loc .".jpg' title='". $row[5] ."' alt='' style='position:relative;float:left;'></img>");
							echo ("		<p style='color:#684684;background-color:#aeaeae;position:absolute;width:100%;padding:3% 0 3% 0;margin-top:50%;'>".$row[5]."</p>");
							echo ("	</div>");
							echo ("</a></li>");
						}
					}
					?>
				</ul>
				<!----- Slider End ----->
			</div>
			<br/>
			<hr>
			<br/>
			<!--------------------------------------------------Recently Bought-------------------------------------------------->
			<div id="popular">
				<h2>Recently Bought</h2>
				<!----- Slider Start ----->
				<ul class="slider_pop" style="padding-bottom:20px;">
					<?php
					$query = "	SELECT 	i.item_id, i.date_last_sold,
										LPAD(i.continent_id,2,'0'),
										LPAD(i.country_id,3,'0'),
										LPAD(i.city_id,3,'0'),
										cit.name, i.date_last_sold
								FROM item i, location_city cit
								where i.city_id = cit.city_id
								order by i.date_last_sold DESC
								LIMIT 10";
					
					$result = 	mysqli_query($conn,$query);
					if ($result) {						
						while($row = mysqli_fetch_row($result)) {
							$loc = $row[2] . "-" . $row[3] . "-" . $row[4];
							echo ("<li class='slide'><a href='product?id=".$row[0]."'>");
							echo ("	<div class='placer'>");
							echo ("		<img src='images/cities/". $loc .".jpg' title='". $row[5] ."' alt='' style='position:relative;float:left;'></img>");
							echo ("		<p style='color:#684684;background-color:#aeaeae;position:absolute;width:100%;padding:3% 0 3% 0;margin-top:50%;'>".$row[5]."</p>");
							echo ("	</div>");
							echo ("</a></li>");
						}
					}
					?>
				</ul>
				<!----- Slider End ----->
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