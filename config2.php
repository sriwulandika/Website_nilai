<?php
	$conn = mysqli_connect('localhost', 'root', '', 'db_sarana_ypk');
	
	if(!$conn){
		die("Error: Failed to connect to database!");
	}
?>