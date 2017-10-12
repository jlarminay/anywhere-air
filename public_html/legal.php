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
		
			<div  style="width:60%;padding:20px 20% 0 20%;background-color:#aeaeae;margin:auto;">
				<dl>
					
					<p><b>All images are owned by their respected parties. </b>
					<br/>If you own the rights to an images found on this site, 
					<br/>you can contact us and we will have the relevant items removed.</p>
					
					<p>The information contained in this website is for general information purposes only. The information is provided by Anywhere Air and while we endeavour to keep the information up to date and correct, we make no representations or warranties of any kind, express or implied, about the completeness, accuracy, reliability, suitability or availability with respect to the website or the information, products, services, or related graphics contained on the website for any purpose. Any reliance you place on such information is therefore strictly at your own risk.
					<br/><br/>In no event will we be liable for any loss or damage including without limitation, indirect or consequential loss or damage, or any loss or damage whatsoever arising from loss of data or profits arising out of, or in connection with, the use of this website.
					<br/><br/>Through this website you are able to link to other websites which are not under the control of Anywhere Air. We have no control over the nature, content and availability of those sites. The inclusion of any links does not necessarily imply a recommendation or endorse the views expressed within them.
					<br/><br/>Every effort is made to keep the website up and running smoothly. However, Anywhere Air takes no responsibility for, and will not be liable for, the website being temporarily unavailable due to technical issues beyond our control.
					<br/><br/>We take no responsibility for the quality of product delivered to consumers via delivery or production the company takes no liability for any damages caused by said products due to radiation smog and/or flatulence
					</p>
					
					<br/>
					
					<dt>Font Provided By: <b>Font Awesome</b><dt>
					<dd><a href="http://fortawesome.github.io/Font-Awesome">http://fortawesome.github.io/Font-Awesome</a></dd>
					<dt><br/></dt>
					
					<dt>Font Provided By: <b>PUNK YOU BRANDS</b></dt>
					<dd><a href="http://punk-you.ru/nautilustype">http://punk-you.ru/nautilustype</a></dd>
					<dt><br/></dt>
					
					<dt>Slider Provided By: <b>BxSlider</b></dt>
					<dd><a href="http://www.bxslider.com">http://www.bxslider.com</a></dd>
					<dt><br/></dt>
					
					<dt>Cookie jQuery Provided By: <b>Klaus Hartl</b></dt>
					<dd><a href="http://plugins.jquery.com/cookie/">http://plugins.jquery.com/cookie/</a></dd>
					<dt><br/></dt>
					
					<dt>Browser Tools Provided By: <b>Bowser</b></dt>
					<dd><a href="https://github.com/ded/bowser">https://github.com/ded/bowser</a></dd>
					<dt><br/></dt>
					
					<dt>Flag Icons Provided By: <b>Icon Drawer</b></dt>
					<dd><a href="http://www.icondrawer.com/">http://www.icondrawer.com/</a></dd>
					<dt><br/></dt>
					
				</dl>
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