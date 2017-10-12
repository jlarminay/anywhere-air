<?php 

print_r($_POST);

$body = $_POST["data"];

if (mail('g.schweden@.com', 'Your Anywhere Air order', $body)) {
	echo "successful";
} else {
	echo "something went wrong. please try again.";
}