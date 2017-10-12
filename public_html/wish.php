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
	
	<link rel="stylesheet" type="text/css" href="css/search.css" />
	<script src="js/wish.js"></script>
	

	<script type="text/javascript">

	$(function() {

		$(document).on( 'click', '.cart', function(){
			$.get("actionCart.php", {"item_id" : $(this).attr("data-id"), "action" : "add", "quantity" : $(this).parent().find(".quantity").val() }, function(data){
				$("#cart_count").html(data);
			});
			$.get("actionWish.php", {"item_id" : $(this).attr("data-id"), "action" : "update", "quantity" : "0" }, function(data){
				show();
			});
		});
	
		//
		//handle wish remove
		//
		$(document).on( 'click', '.wish', function(){
			//alert($(this).attr("data-id"));
			$.get("actionWish.php", {"item_id" : $(this).attr("data-id"), "action" : "update", "quantity" : $(this).parent().find(".quantity").val() }, function(data){
				show();
			});
		});

	});

	function show() {
			//Open a connection to the server and send a request.
	    	$.get("pullWish.php", {}, function(data){
				$("#showWish").html(data);
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
			
			<?php
			
			if (!empty($_COOKIE['user'])){
				echo ('
					<div id="showWish" class="clearfix">
					</div>
				');
			}
			else {
				echo ("<div style='padding:2%;font-size:120%;text-align:center;background-color:#aeaeae;'>User Not Found</div>");
			}
			
			?>
			
		</div>
	</div>
</body>

<footer>
	<?php
	footer_print($conn);	
	?>
</footer>
</html>