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
	
	<link rel="stylesheet" type="text/css" href="css/cart.css" />
	<link rel="stylesheet" type="text/css" href="css/search.css" />
	<script src="js/cart.js"></script>
	

	<script type="text/javascript">

	$(function() {

		//
		//handle cart remove
		//
		$(document).on( 'click', '.cart', function(){
			//alert($(this).attr("data-id"));
			$.get("actionCart.php", {"item_id" : $(this).attr("data-id"), "action" : "update", "quantity" : $(this).parent().find(".quantity").val() }, function(data){
				$("#cart_count").html(data);
				show();
			});
		});

	});

	function show() {
			//Open a connection to the server and send a request.
	    	$.get("pullCart.php", {}, function(data){
				$("#showCart").html(data);
			});

	}


	</script>

</head>

<body onload="show();">

	<div id="wall"></div>

		<div id="full" class="clearfix">
		
			<?php
			header_print($conn);	
			?>
			
			<br/>	
				
			<div id="showCart" class="clearfix">
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