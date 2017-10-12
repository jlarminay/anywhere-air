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
	
</head>

<body>

	<div id="wall"></div>

	<div id="full">
	
		<?php
		header_print($conn);	
		?>
		
		<br/>	
		
		<div id="container">
			
			<div  style="width:80%;text-align:center;background-color:#aeaeae;margin:auto;padding:10px;">
				<p>This was result of our Year 1 project at Camosun College.</p>			
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