<?php

require 'cleaner.php';

echo ("<title>Search XML</title>");

require "../../library/connect.php";
$conn = server_connect_select();

$query = "	select * 
			from items 
			where "

?>