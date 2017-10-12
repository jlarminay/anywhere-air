
<?php
session_start();
// prints item detailt and totals for items in cart

if (isset($_COOKIE["user"])) {
	$x= explode("-",$_COOKIE["user"]);
	$usr = $x[0];
	$acc = True;
} else {
	$acc = False;
}


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
					format(trans.price,2), item.item_id, bottle.size, trans.quantity
			from item
			inner join location_continent cont on (item.continent_id = cont.continent_id)
			inner join location_country coun on (item.country_id = coun.country_id)
			inner join location_city city on (item.city_id = city.city_id)
			inner join bottle on (item.bottle_id = bottle.bottle_id)
			inner join transactions trans using (item_id)
			where item.item_id in (select item_id from transactions where trans_id = (select max(trans_id) from purchases where user_id = ".$usr.")) AND trans_id = (select max(trans_id) from purchases where user_id = ".$usr.") ";
	
	
	$result =	mysqli_query($conn,$query);
	//print_r($result);
	
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
			$code = $row[0].'-'.$row[1].'-'.$row[2];
			echo ('	<div class="item clearfix">');
			echo ('		<div class="im">');
			echo ('			<a href="product?id='.$row[7].'"><img src="images/cities/'.$code.'" alt="" width="100%"></img></a>');
			echo ('		</div>');
			echo ('		<div class="desc">');
			echo ('			<h4>'.$row[5].', '.$row[4].', '.$row[3].'</h4>');
			echo ('			<p>Bottle: '.$row[8].'</p>');
			echo ('			<p>Size: '.$row[12].'</p>');
			echo ('			<p>Weight: '.$row[9].'</p>');
			echo ('			<p style="font-size:120%;color:blue;">Price: $'.$row[10].'</p>');
			echo ('		</div>');
			echo ('		<div class="curt">');
							$quantity = $row[13];
							$toPay = $quantity*$row[10];
							$totalToPay += $toPay;
			echo ('			<p class="price">Total Price: '.money_format('$%i', $toPay).'</p>');
			echo ('			<label for="quantity">Quantity: '.$quantity.'</label>');
			echo ('		</div>');
			echo ('	</div>');
		}
		echo ("</table>");
		
		echo ("</div>");
		
		echo ("<div style='float:right;width:20%;background-color:#aeaeae;padding:8px;text-align:center;'>");
		echo ('<p>Total payed:<br/><b>'.money_format('$%i', $totalToPay).'<b/></p>');	
		
		echo ("</div>");
	} 
	else {
		//echo mysqli_error($conn);
		echo ("<div style='width:100%;float:left;background-color:#aeaeae;padding:10px;'>");
		echo "<p style='text-align:center;'>Not sure how you got here, but I got nothing for you</p>";
		echo ("</div>");
	}
} 
else {
	echo ("<div style='width:100%;float:left;background-color:#aeaeae;padding:10px;'>");
	echo "<p style='text-align:center;'>Not sure how you got here, but I got nothing for you</p>";
	echo ("</div>");
}
