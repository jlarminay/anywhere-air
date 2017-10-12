<?php
session_start();
// prints item detailt and totals for items in wish

if (isset($_SESSION['wish'])) {
	$wish = $_SESSION['wish'];
	$ids = array();
	foreach ($wish as $k => $x) {
		$ids[] = $k;
	}
	$id_array = $ids;
	$ids = implode($ids,",");
	
	require "../library/connect.php";
	$conn = server_connect();
	
	$string = explode('-',$_COOKIE['user']);
	$uid = $string[0];
	
	/*
	$query = "select cont.name as continent, coun.name as country, city.name as city, item.description, bottle.type, item.price as price, item.item_id as item_id
				from item
				inner join location_continent cont on (item.continent_id = cont.continent_id)
				inner join location_country coun on (item.country_id = coun.country_id)
				inner join location_city city on (item.city_id = city.city_id)
				inner join bottle on (item.bottle_id = bottle.bottle_id) ";
	$query .= " where item.item_id in (".$ids.")";
	*/
	
	$query = "	select 	lpad(cont.continent_id,2,'0'), lpad(coun.country_id,3,'0'), lpad(city.city_id,3,'0'), 
					cont.name, coun.name, city.name, 
					item.description, item.item_id,
					bottle.type, bottle.weight, 
					format(item.price,2), item.item_id, bottle.size, 
					wish.quantity, item.quantity_available
			from wish
			inner join item on(wish.item_id = item.item_id)
			inner join location_continent cont on (item.continent_id = cont.continent_id)
			inner join location_country coun on (item.country_id = coun.country_id)
			inner join location_city city on (item.city_id = city.city_id)
			inner join bottle on (item.bottle_id = bottle.bottle_id)
			where wish.user_id = ".$uid."";
	
	
	$result =	mysqli_query($conn,$query);
	
	if ($result) {
		$rows = mysqli_num_rows($result);
		if ($rows > 0){
			echo ("<div style='width:98%;float:left;background-color:#aeaeae;padding:10px;'>");
			$price = 0.00;
			$toPay = 0.00;
			$totalToPay = 0.00;
			
			/*
			echo ("<table border>");
			while ($row=mysqli_fetch_assoc($result)){
				echo ("<tr>");
				foreach($row as $key => $cell) {
					if ($key == "price") {
						$price = $cell;
						echo ("<td>$price</td>");
					}
					if ($key == "item_id") {
						$toPay = $wish[$cell]*$price;
						$totalToPay += $toPay;
						echo ('<td>'.$wish[$cell].'<td><button type="button" onclick="wishMinus();" class="wish" data-id="'.$cell.'">remove</button></td><td>'.$toPay.'</td>');
					} else {
						echo ("<td>$cell</td>");
					}
				}
				echo ("</tr>");
			}
			echo ("</table>");
			*/
			
			while($row = mysqli_fetch_row($result)) {
				$s_query = "select format(sale_price,2), date_start, date_end 
							from sale
							where item_id = '".$row[7]."'";
				$s_result = mysqli_query($conn,$s_query);
				$code = $row[0].'-'.$row[1].'-'.$row[2];
				echo ('	<div class="item clearfix">');
				echo ('		<div class="im">');
				echo ('			<a href="product?id='.$row[7].'"><img src="images/cities/'.$code.'" alt="" width="100%"></img></a>');
				echo ('		</div>');
				echo ('		<div class="desc">');
				echo ('			<h4>'.$row[5].', '.$row[4].', '.$row[3].'</h4>');
				echo ('			<p>Bottle: '.$row[8].'</p>');
				echo ('			<p>Size: '.$row[12].'</p>');
								if($s_result){
									$s_rows = 	mysqli_num_rows($s_result);
									if ($s_rows>0){
										$s_row = mysqli_fetch_row($s_result);
				echo ('					<p style="font-size:120%;color:blue;"><s>Price: $'.$row[10].'</s></p>');
				echo ('					<p style="font-size:120%;color:blue;"><b>Sale: $'.$s_row[0].'</b></p>');
										$cost = $s_row[0];	
									}
									else {
				echo ('					<p style="font-size:120%;color:blue;">Price: $'.$row[10].'</p>');
										$cost = $row[10];
									}
								}
								
								if ($row[14]>0){
				echo ('				<p id="stock" style="color:green;"><b>In Stock</b></p>');							
								}
								else{
				echo ('				<p id="stock" style="color:red;"><b>Out Of Stock</b></p>');
								}
								
				echo ('		</div>');
				echo ('		<div class="curt">');
								$quantity = $wish[$row[7]];
								$toPay = $quantity*$cost;
								$totalToPay += $toPay;
				echo ('			<p class="price">Total Price: '.money_format('$%i', $toPay).'</p>');
				echo ('			<label for="quantity">Quantity:</label>');
				echo ('			<select class="quantity" name="quantity" style="padding:3px;">');
								$i = 0;
								while ($i < 100){
									if ($i == $quantity){
										echo ("<option value='$i' selected>$i</option>");
									}
									else {
										echo ("<option value='$i'>$i</option>");
									}
									$i++;
								}		
				echo ('			</select>');
				echo ('			<br/>');
				echo ('			<button type="button" onclick="wishMinus();" class="wish" data-id="'.$row[7].'">Update</button>');
				
								if ($row[14] > 0){
				echo ("			<button type='button' class='cart' data-id='$row[11]'><i class='fa fa-cart-plus'></i> Add To Cart</button>");
								}
								else {
				echo ("			<button type='button' class='cart' disabled> Add To Cart</button>");
								}
				
				echo ('		</div>');
				echo ('	</div>');
			}
			
			echo ("</div>");
		}
		else {
			echo ("<div style='width:98%;float:left;background-color:#aeaeae;padding:10px;'>");
			echo "<p style='text-align:center;'>No items in wish list</p>";
			echo ("</div>");
		}
	}
	else {
		//echo mysqli_error($conn);
		echo ("<div style='width:98%;float:left;background-color:#aeaeae;padding:10px;'>");
		echo "<p style='text-align:center;'>No items in wish list</p>";
		echo ("</div>");
	}
} 
else {
	echo ("<div style='width:98%;float:left;background-color:#aeaeae;padding:10px;'>");
	echo "<p style='text-align:center;'>No items in wish list</p>";
	echo ("</div>");
}
