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
	
	<link rel="stylesheet" type="text/css" href="css/product.css" />

	<script>
	$(function() {
		$(document).on( 'click', '#cart', function(){
			//alert($("#quantity").val());
			//alert($(this).attr("data-id"));
			$.get("actionCart.php", {"item_id" : $(this).attr("data-id"), "action" : "add", "quantity" : $("#quantity").val() }, function(data){
				$("#cart_count").html(data);
			});
		});
		$(document).on( 'click', '#wish', function(){
			$.get("actionWish.php", {"item_id" : $(this).attr("data-id"), "action" : "add", "quantity" : $("#quantity").val() });
		});
	});
	</script>

</head>

<body>

	<div id="wall"></div>

	<div id="full">
	
		<?php
		header_print($conn);	
		?>
		
		<br/>	
		
		
			
			<?php
			$id = $_GET['id'];
			
			$query = "	select 	i.item_id, format(i.price,2), i.description, 
								b.type, b.size, b.weight,
								lpad(con.continent_id,2,'0'), con.name,
								lpad(cou.country_id,3,'0'), cou.name,
								lpad(cit.city_id,3,'0'), cit.name,
								i.quantity_available
						from item i, bottle b, location_continent con, location_country cou, location_city cit
						where i.bottle_id = b.bottle_id
						and i.continent_id = con.continent_id
						and i.country_id = cou.country_id
						and i.city_id = cit.city_id
						and i.item_id = '".$id."'";
			$result = mysqli_query($conn,$query);
			
			$s_query = "select format(sale_price,2), date_start, date_end 
						from sale
						where item_id = '".$id."'
						and date_end > now() 
						and date_start < now()";
			$s_result = mysqli_query($conn,$s_query);
			$sale = False;
			
			if ($result){
				$rows = 	mysqli_num_rows($result);
				$fields = 	mysqli_num_fields($result);
				if ($rows > 0) {
					$row = mysqli_fetch_row($result);
					//------------------------------------------------------
					echo ('		<div id="container" class="clearfix">');
					echo ('			<div id="top" class="clearfix">');
					$code = $row[6]."-".$row[8]."-".$row[10];
					echo ('				<div id="img">');
					echo ('					<table border><tr><td>');
					echo ('						<img src="images/cities/'.$code.'.jpg" alt="" ></img>');
					echo ('					</td></tr></table>');
					echo ('				</div>');
					echo ('				<div id="data">');
					echo ('					<h2>'.$row[11].'</h2>');
					echo ('					<h3>'.$row[9].', '.$row[7].'</h3>');
					echo ('					<p>Bottle Type: '.$row[3].'</p>');
					echo ('					<p>Size: '.$row[4].'</p>');
					echo ('					<p>Weight: '.$row[5].'</p>');
											if ($s_result){
												$s_rows = 	mysqli_num_rows($s_result);
												if ($s_rows>0){
													$sale = True;
													$s_row = mysqli_fetch_row($s_result);
													echo ('<p>Price: <s><b>'.money_format('$%i', $row[1]).'</b></s></p>');
													echo ('<p style="font-size:120%;color:blue;">Sale Price: <b>'.money_format('$%i', $s_row[0]).'<b></p>');
													echo ('<p style="font-size:80%;">Sale Ends: '.$s_row[2].'</p>');
												}
												else {
													echo ('<p>Price: <b>'.money_format('$%i', $row[1]).'</b></p>');
												}
											}
											if ($row[12]>0){
					echo ('						<p id="stock" style="color:green;"><b>In Stock</b></p>');							
											}
											else{
					echo ('						<p id="stock" style="color:red;"><b>Out Of Stock</b></p>');
											}
					echo ('				</div>');
					echo ('				<div id="basket">');
					echo ('					<!-- ADD TO CART -->');
											if ($row[12] > 0){
					echo ('						<button id="cart" type="button" data-id="'.$row[0].'"><i class="fa fa-cart-plus"></i> Add To Cart</button>');
											}
											else {
					echo ('						<button id="cart" type="button" disabled><i class="fa fa-cart-plus"></i> Add To Cart</button>');
											}
											
											if (!empty($_COOKIE['user'])){
					echo ('						<button id="wish" type="button" data-id="'.$row[0].'"><i class="fa fa-list"></i> Add To Wish List</button>');
											}
											
					echo ('					<br/>');
					echo ('					<label for="quantity">Quantity:</label>');
					echo ('					<select name="quantity" id="quantity">');
											$i = 1;
											while ($i < 100){
												echo ("<option value='$i'>$i</option>");
												$i++;
											}					
					echo ('					</select>');
					echo ('				</div>');
					echo ('			</div>');
					echo ('			<div id="desc">');
					echo ('				<h2>Product Description</h2>');
					echo ('				<p>'.$row[2].'</p>');
					echo ('			</div>');
					echo ('		</div>');
					//------------------------------------------------------
				}
				else {
					echo ("<p style='text-align:center;'>Item Not Found</p>");
				}
			}
			else {
				echo ("<p style='text-align:center;>Item Not Found</p>");
			}
			
			?>
	</div>
</body>

<footer>
	<?php
	footer_print($conn);	
	?>
</footer>
</html>