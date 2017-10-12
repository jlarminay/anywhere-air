<?php

//where do I start? gets filtered query through ajax, builds sql query then produces output. also creates add to cart button.

require "../library/connect.php";

$conn = server_connect();

$query = "	select 	lpad(cont.continent_id,2,'0'), lpad(coun.country_id,3,'0'), lpad(city.city_id,3,'0'), 
					cont.name, coun.name, city.name, 
					item.description, item.item_id,
					bottle.type, bottle.weight, 
					format(item.price,2), item.item_id, bottle.size,
					item.quantity_available
			from item
			inner join location_continent cont on (item.continent_id = cont.continent_id)
			inner join location_country coun on (item.country_id = coun.country_id)
			inner join location_city city on (item.city_id = city.city_id)
			inner join bottle on (item.bottle_id = bottle.bottle_id) ";
			
$sale= $_GET['sale'];
$recent= $_GET['recent'];
$continents= $_GET['continents'];
$countries = $_GET['countries'];
$types= $_GET['types'];
$weights= $_GET['weights'];
$prices= $_GET['prices'];
$sort= $_GET['sort'];
$where = array();

$search = $_GET['search'];

if ($search != "") {
	//array of unwelcome input
	$takeMe = array("/\;/", "/drop/", "/delete/", "/insert/");
	//takes unwelcome items out of input
	foreach ($takeMe as $takeThis){
		$search = preg_replace ($takeThis, "", strtolower($search), -1, $result);
	}
	$where[] = "lower(cont.name) like '%".$search."%' or lower(coun.name) like '%".$search."%' or lower(city.name) like '%".$search."%'";
}



if ($sale == 'true') {
	$where[] = " item_id in (select item_id from sale where date_end > now() and date_start < now()) ";
}
if ($recent == 'true') {
	$where[] = " item.date_added  >= now() - interval 8 week";
	//$where[] = " item.item_id in (select item_id from item order by date_added desc limit 5) ";
}

$or = array();
if ($continents != "") {
	$or[] = "item.continent_id in (".$continents.") ";
}
if ($countries != "") {
	$or[] = "item.country_id in (".$countries.") ";
}
if($or) {
	$where[] = "(".implode($or, " or ").")";
}

if ($types != "") {
	$where[] = "bottle.type in (".$types.") ";
}

if ($weights != "") {
	$min = 0.15;
	$max = 0.80;
	$add = array();
	$array = explode(",",$weights);
	foreach ($array as $w) {
		(float)($w);
		$x = $w/$min;
		if ($x <=1) {
			$add[] = " bottle.weight <= $min ";
		} elseif ($w > $max) {
			$add[] = " bottle.weight >= $max ";
		} else {
			$add[] = " bottle.weight between ".$min*($x-1)." and ".$min*$x." ";
		}
	}
	$where[] = "(".implode($add, " or ").")";
}

if ($prices != "") {
	$min = 5;
	$max = 20;
	$add = array();
	$array = explode(",",$prices);
	foreach ($array as $p) {
		$p=(float)($p);
		$x = $p/$min;
		if ($x <=1) {
			$add[] = " item.price <= $min ";
		} elseif ($p > $max) {
			$add[] = " item.price >= $max ";
		} else {
			$add[] = " item.price between ".$min*($x-1)." and ".$min*$x." ";
		}
	}
	$where[] = "(".implode($add, " or ").")";
}

if ($where) {
	$query .= "where ".implode($where, " and ");
}

if ($sort) {
	$order = " order by ";
	switch ($sort) {
		case "az1": $order .= "cont.name";
		break;
		case "az2": $order .= "coun.name";
		break;
		case "az3": $order .= "city.name";
		break;
		case "pl": $order .= "item.price";
		break;
		case "ph": $order .= "item.price desc";
		break;
		case "p": $order .= "item.total_sold desc";
		break;
		case "no": $order .= "item.date_added";
		break;
		case "on": $order .= "item.date_added desc";
		break;
		default: $order = "";
	}
	$query.= $order;
}

/*
print "weight: ";
print_r($weights);
print "<br/>sort: ";
print_r($sort);
print "<br/>continents: ";
print_r($continents);
print "<br/>countries: ";
print_r($countries);
print "<br/>types: ";
print_r($types);
print "<br/>sale: ";
print_r($sale);
print "<br/>prices: ";
print_r($prices);
print "<br/><br/>";
print "Query: ".$query."<br/>";
*/


$result = 	mysqli_query($conn,$query);

//$.get(("searchAction.php?sort="+sort+"&continents="+continents+"&countries="+countries+"&sale="+sale+"&types="+types+"&weights="+weights

$today = getdate();
$date = $today['year']."-".$today['mon']."-".$today['mday'];

//if results returned true
if ($result) {
	$rows = 	mysqli_num_rows($result);
	$fields = 	mysqli_num_fields($result);
	
	if ($rows > 0) {

		//				0							1								2						3						4						5				6					7			8			9				10						11					12
		//select lpad(cont.continent_id,2,'0'), lpad(coun.country_id,3,'0'), lpad(city.city_id,3,'0'), cont.name as continent, coun.name as country, city.name as city, item.description, item.item_id, bottle.type, bottle.weight, format(item.price,2), item.item_id as item_id, bottle.size
		
		/*while($row = mysqli_fetch_row($result)) {
			echo ("<tr>");
			$code = $row[0].'-'.$row[1].'-'.$row[2];
			echo ("<td><a href='product?id=$row[7]'><img src='images/cities/$code' alt='' width='100%'></img></a></td>");
			echo ("<td>$row[3]</td>");
			echo ("<td>$row[4]</td>");
			echo ("<td>$row[5]</td>");
			echo ("<td>$row[6]</td>");
			echo ("<td>$row[8]</td>");
			echo ("<td>$row[9]</td>");
			echo ("<td>$row[10]$</td>");
			echo	'<td><select name="quantity" id="quantity">';
						$i = 1;
						while ($i < 100){
							echo ("<option value='$i'>$i</option>");
							$i++;
						}					
			echo 	'</select></td>';
			echo ("<td><button type='button' class='cart' data-id='$row[11]'><i class='fa fa-cart-plus'></i></button></td>");
			echo ("</tr>");
		}*/
		while($row = mysqli_fetch_row($result)) {			
			$s_query = "select format(sale_price,2), date_start, date_end 
						from sale
						where item_id = '".$row[7]."'
						and date_end > now() 
						and date_start < now()";

			$s_result = mysqli_query($conn,$s_query);
			$code = $row[0].'-'.$row[1].'-'.$row[2];
			echo ('	<div class="item clearfix">');
			echo ('		<div class="im">');
			echo ('			<a href="product?id='.$row[7].'"><img src="images/cities/'.$code.'.jpg" alt="" width="100%"></img></a>');
			echo ('		</div>');
			echo ('		<div class="desc">');
			echo ('			<h4>'.$row[5].'</h4>');
			echo ('			<h3 style="margin:0;padding-left:5px;">'.$row[4].', '.$row[3].'</h3>');
			echo ('			<p>Bottle: '.$row[8].'</p>');
			echo ('			<p>Size: '.$row[12].'</p>');
							if ($row[13] > 0){
			echo ('				<p style="color:green">In Stock</p>');					
							}
							else {
			echo ('				<p style="color:red">Out Of Stock</p>');					
							}
			echo ('			<p>'.substr($row[6],0,40).'...</p>');
			echo ('		</div>');
			echo ('		<div class="curt">');
							if ($s_result){
								$s_rows = 	mysqli_num_rows($s_result);
								if ($s_rows>0){
									$s_row = mysqli_fetch_row($s_result);
			echo ('					<p class="price" style="margin-bottom:0;"><s>Price: '.money_format('$%i', $row[10]).'</s></p>');
			echo ('					<p class="price" style="margin-top:0;"><b>Sale: '.money_format('$%i', $s_row[0]).'</b></p>');
								}
								else {
			echo ('					<p class="price">Price: '.money_format('$%i', $row[10]).'</p>');
								}
							}
			echo ('			<label for="quantity">Quantity:</label>');
			echo ('			<select name="quantity" class="quantity">');
							$i = 1;
							while ($i < 100){
								echo ("<option value='$i'>$i</option>");
								$i++;
							}		
			echo ('			</select>');
			echo ('			<br/>');
							if ($row[13] > 0){
			echo ("				<button type='button' class='cart' data-id='$row[11]'><i class='fa fa-cart-plus'></i> Add To Cart</button>");
							}
							else {
			echo ("				<button type='button' class='cart' disabled><i class='fa fa-cart-plus'></i> Add To Cart</button>");
							}
							if (!empty($_COOKIE['user'])){
			echo ("				<button type='button' class='wish' data-id='$row[11]'><i class='fa fa-list'></i> Add To Wish List</button>");
							}
			echo ('		</div>');
			echo ('	</div>');
		}
	}
	else {
		echo ("No Results");
	}
}
else {
	echo ("No Results");
}