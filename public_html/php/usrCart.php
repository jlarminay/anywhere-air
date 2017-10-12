<?php
session_start();
// handles session for add to cart event and returns amount of items in cart for ajax.
// still needs database action!
$_SESSION['log'] = "begin log <br />";

function mergeCart($usr,$conn) {
	require "mysql.php";
	//if there are items in the cart add them to the data base
	if (isset($_SESSION['cart'])) {
		$cart = $_SESSION['cart'];
		foreach ($cart as $item_id => $quantity) {
			$query = "INSERT INTO cart (user_id, item_id, quantity) VALUES ($usr, $item_id, $quantity) ON DUPLICATE KEY UPDATE quantity = $quantity ";
			dbUpdate($query,$conn);
		}
	}
	$cart = array();

	$query = "SELECT item_id, quantity FROM cart WHERE user_id = $usr";
	$result =	mysqli_query($conn,$query);

	if ($result) {
		while ($row=mysqli_fetch_assoc($result)){
			$cart[$row["item_id"]] = $row["quantity"];
		}
		$_SESSION['cart'] = $cart;
	} else {
		$_SESSION['log'] .= mysqli_error($conn);
	}

}


