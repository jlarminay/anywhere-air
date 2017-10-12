<?php
session_start();
// prints item detailt and totals for items in cart

if (isset($_SESSION['cart'])) {
	$cart = $_SESSION['cart'];
	$ids = array();
	foreach ($cart as $k => $x) {
		$ids[] = $k;
	}
	$id_array = $ids;
	$ids = implode($ids,",");
	
	require "../library/connect.php";
	$conn = server_connect();
	
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
					format(item.price,2), item.item_id, bottle.size
			from item
			inner join location_continent cont on (item.continent_id = cont.continent_id)
			inner join location_country coun on (item.country_id = coun.country_id)
			inner join location_city city on (item.city_id = city.city_id)
			inner join bottle on (item.bottle_id = bottle.bottle_id)
			where item.item_id in (".$ids.")";
	
	
	$result =	mysqli_query($conn,$query);
	
	if ($result) {
		echo ("<div style='width:74%;float:left;background-color:#aeaeae;padding:10px;'>");
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
					$toPay = $cart[$cell]*$price;
					$totalToPay += $toPay;
					echo ('<td>'.$cart[$cell].'<td><button type="button" onclick="cartMinus();" class="cart" data-id="'.$cell.'">remove</button></td><td>'.$toPay.'</td>');
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
						where item_id = '".$row[7]."' and date_end > now() and date_start < now()";
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
			echo ('		</div>');
			echo ('		<div class="curt">');
							$quantity = $cart[$row[7]];
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
			echo ('			<button type="button" onclick="cartMinus();" class="cart" data-id="'.$row[7].'">Update</button>');
			echo ('		</div>');
			echo ('	</div>');
		}
		
		echo ("</div>");
		
		echo ("<div style='float:right;width:20%;background-color:#aeaeae;padding:8px;text-align:center;'>");
		echo ('<p>Total to pay:<br/><b>'.money_format('$%i', $totalToPay).'</b></p>');

		///
		///STIRPE API
		///
		if (isset($_COOKIE["user"])) {
			$x= explode("-",$_COOKIE["user"]);
			$usr = $x[0];
			$query = "select * from users where user_id = $usr";
			$result = mysqli_query($conn,$query);
			$row = mysqli_fetch_array($result);
			
			$i = 0;
			$test = true;
			
			while ($i < 15){
				if ($row[$i] == ''){
					$test = false;
				}
				$i++;
			}
			
			if ($test == true){
				print '
					<form action="./handle.php" method="POST">
					  <script
						src="https://checkout.stripe.com/checkout.js" class="stripe-button"
						data-key="pk_test_LwnDIDi44JvHHtMz335IuEkB"
						data-amount="'.round($totalToPay*100).'"
						data-name="Anywhere Air"
						data-description="fresh* air from anywhere"
						data-image="./images/avatar.png"
						data-email="'.$row[5].'">

					  </script>
					  <input type="hidden" name="amount" value="'.round($totalToPay*100,0).'">
					</form>';
			} 
			else {
				echo ("<a href='user.php'style='border:1px solid black;background-color:grey;padding:5px;color:black;'>Please Fill Out Order Info</a>");
			}
		
			
		} 
		else {
			//echo mysqli_error($conn);
			echo ("<a href='login.php' style='border:1px solid black;background-color:grey;padding:5px;color:black;'>Please Log In To Continue</a>");
		}
		
		echo ("</div>");
	}
} 
else {
	echo ("<div style='width:100%;float:left;background-color:#aeaeae;padding:10px;'>");
	echo "<p style='text-align:center;'>No items in cart</p>";
	echo ("</div>");
}

?>