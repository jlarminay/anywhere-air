<?php
require "../../library/template.php";
$conn = start();
?>
<html>
<head>
	<title>Anywhere Air</title>
	<link rel="icon" type="image/ico" href="../images/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../css/style.css" />
	<link rel="stylesheet" type="text/css" href="module.css" />
	
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../fonts/blackrose_regular_macroman/stylesheet.css" />
	<link rel="stylesheet" type="text/css" href="../fonts/nautilus/stylesheet.css" />
	
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
</head>

<body>

	<div id="wall"></div>

	<div id="full">
	
		<?php
		header_print($conn,'../');	
		?>
		
		<br/>	
		
		<div id="container">
			
			<h2>API Module</h2>
			
			<p>Currently, all API requests are accepted via HTTP requests.</p>
			
			<div id="search">
				<h3>Search Function</h3>
				<br/>
				<dl>
					<dt>URL:</dt>
					<dd>http://joshlarminay.com/projects/anywhere_air/public_html/api/search.php?q=victoria</dd>
					
					<dt>Format:</dt>
					<dd>xml</dd>
					
					<dt>Parameters:</dt>
					<dd>
						<ul>
							<li>q. Required. URL encoded string of city, country or continent to search for.</li>
							<ul>
								<li>Example: http://joshlarminay.com/projects/anywhere_air/public_html/api/search.php?q=south+africa</li>
							</ul>
						</ul>
					</dd>
					
					<dt>Response:</dt>
					<dd>Success: 200 status code, XML data for product.
					<br/>Failure: 204 status code.</dd>
			</div>
			
		</div>
	</div>
</body>

<footer>
	<?php
	footer_print($conn,'../');	
	?>
</footer>
</html>