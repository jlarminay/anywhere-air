<?php
session_start();
// handles session for add to wish event and returns amount of items in wish for ajax.
// has database action!

$quantity = 1;
if (isset($_GET['quantity'])) {
	$quantity = $_GET['quantity'];
}

if (isset($_SESSION['wish'])) {
	$wish = $_SESSION['wish'];
} 
else {
	$wish = array();
}

$item = $_GET['item_id'];

if (isset($_COOKIE["user"])) {
	$x= explode("-",$_COOKIE["user"]);
	$usr = $x[0];
	$acc = True;
} else {
	$acc = False;
}

if(!isset($wish[$item])) {$wish[$item] = 0;}

if ($_GET['action'] == 'update') {
	$wish[$item] = $quantity;
	if ($wish[$item] < 1) {
		unset($wish[$item]);
		if($acc) {$query = "DELETE FROM wish WHERE user_id = $usr AND item_id = $item ";}
	} else {
		if($acc) {$query = "UPDATE wish SET quantity=".$wish[$item]." WHERE user_id = $usr AND item_id = $item ";}
	}
}
else {
	$wish[$item] += $quantity;
	if ($wish[$item] == $quantity) {
		if($acc) {$query = "INSERT INTO wish (user_id, item_id, quantity) VALUES ($usr, $item, $quantity) ";}
	} else {
		if($acc) {$query = "UPDATE wish SET quantity=".$wish[$item]." WHERE user_id = $usr AND item_id = $item ";}
	}
}

$_SESSION['wish'] = $wish;

$count = 0;
foreach ($_SESSION['wish'] as $k => $x) {
	$count += $x;
}

if($acc) {
	require "php/mysql.php";
	dbUpdate ($query);
}

echo $count;