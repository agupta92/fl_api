<?php
	$host="localhost"; // Host name
	$username="bloomigo_search"; // mysqli username
	$password="9893044015"; // mysqli password
	$db_name="bloomigo_search"; // Database name
	// Connect to server and select database.
	$db = mysqli_connect("$host", "$username", "$password")or die("cannot connect");
	mysqli_select_db($db, $db_name)or die("cannot select DB");
?>