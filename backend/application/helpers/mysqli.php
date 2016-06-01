<?php
	$host="localhost"; // Host name
	$username="bloom_main"; // Mysql username
	$password="CleaverSharks123"; // Mysql password
	$db_name="bloom_search"; // Database name
	// Connect to server and select database.
	&db1 = mysql_connect("$host", "$username", "$password")or die("cannot connect");
	mysql_select_db($db1 , $db_name)or die("cannot select DB");
?>