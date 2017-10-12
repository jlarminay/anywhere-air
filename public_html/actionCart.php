<?php
session_start();
// handles session for add to cart event and returns amount of items in cart for ajax.
// has database action!

$quantity = 1;
if (isset($_GET['quantity'])) {
	$quantity = $_GET['quantity'];
}

if (isset($_SESSION['cart'])) {
	$cart = $_SESSION['cart'];
} 
else {
	$cart = array();
}

$item = $_GET['item_id'];

if (isset($_COOKIE["user"])) {
	$x= explode("-",$_COOKIE["user"]);
	$usr = $x[0];
	$acc = True;
} else {
	$acc = False;
}

if(!isset($cart[$item])) {$cart[$item] = 0;}

if ($_GET['action'] == 'update') {
	$cart[$item] = $quantity;
	if ($cart[$item] < 1) {
		unset($cart[$item]);
		if($acc) {$query = "DELETE FROM cart WHERE user_id = $usr AND item_id = $item ";}
	} else {
		if($acc) {$query = "UPDATE cart SET quantity=".$cart[$item]." WHERE user_id = $usr AND item_id = $item ";}
	}
} 
else {
	$cart[$item] += $quantity;
	if ($cart[$item] == $quantity) {
		if($acc) {$query = "INSERT INTO cart (user_id, item_id, quantity) VALUES ($usr, $item, $quantity) ";}
	} else {
		if($acc) {$query = "UPDATE cart SET quantity=".$cart[$item]." WHERE user_id = $usr AND item_id = $item ";}
	}
}

$_SESSION['cart'] = $cart;

$count = 0;
foreach ($_SESSION['cart'] as $k => $x) {
	$count += $x;
}

if($acc) {
	require "php/mysql.php";
	dbUpdate ($query);
}

echo $count;