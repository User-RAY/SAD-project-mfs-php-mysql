<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = $_POST['name'];
	$nid = $_POST['nid'];
	$phone = $_POST['phone'];
	$pin = $_POST['pin'];

}

	// Database connection
	$conn = new mysqli('localhost','root','','mfs_batash');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		 // Check if NID or phone already exists in the database
		 $checkQuery = $conn->prepare("SELECT id FROM users WHERE nid = ? OR phone = ?");
		 $checkQuery->bind_param("ss", $nid, $phone);
		 $checkQuery->execute();
		 $checkQuery->store_result();
 
		 if ($checkQuery->num_rows > 0) {
			 // NID or phone already exists
			 $checkQuery->close();
			 die("NID or phone number already exists. Please use a different one.");

	 
		 }
 
		 $checkQuery->close();

		$stmt = $conn->prepare("insert into users(name, nid, phone, pin) values(?, ?, ?, ?)");
		$stmt->bind_param("ssss", $name, $nid, $phone, $pin);
		$execval = $stmt->execute();
		echo $execval;
		echo "Registration successfully...";
		$stmt->close();

		// session
		$_SESSION["name"] = $name;
		$_SESSION["nid"] = $nid;
		$_SESSION["phone"] = $phone;
		// $_SESSION["pin"] = $pin;

        header("location: /sad/index.php");
        exit();


		$conn->close();
	}
?>