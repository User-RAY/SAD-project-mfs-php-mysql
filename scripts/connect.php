<?php

function getDbCon(){
	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "mfs_batash";

	// Database connection
	$conn = new mysqli($servername, $username, $password, $database);
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} 

	return $conn;
}


?>