<?php
session_start();
include "scripts/connect.php"; 

// Check if the user is logged in (based on session variable)
if (!isset($_SESSION["phone"])) {
    // Redirect to login page if not logged in
    header("location: index.php");
    exit;
}

// Get the logged-in user's phone number from the session
$phone = $_SESSION["phone"];

// Create database connection
$dbCon = getDbCon();

// Prepare SQL to fetch the user's name and balance
$stmt = $dbCon->prepare("SELECT name, balance FROM users WHERE phone = ?");
$stmt->bind_param("s", $phone);
$stmt->execute();
$stmt->bind_result($name, $balance);
$stmt->fetch();
$stmt->close();

// Close the connection
$dbCon->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batash</title>


    <!-- CUSTOM CSS STYLES -->
    <link rel="stylesheet" href="styles/class.css">
    <link rel="stylesheet" href="styles/home.css">

</head>

<body class="min-h-screen flex flex-col">
    
<div class="container">
    <!-- Balance Section -->
    <div class="balance-card">
        <div class="balance">
        $<?php echo number_format($balance, 2); ?>
            <span>Available Balance</span>
        </div>
        <a href="scripts/logout.php"><button class="btn-logout">Log Out</button></a>
    </div>

    <!-- Welcome Message -->
     <h1>Hello <?php echo htmlspecialchars($name); ?></h1>
    <h2 class="welcome">Welcome to BATASH!</h2>
    <p class="description">Enjoy easy and convenient financial services with us. No Cashout charge</p>

    <!-- Actions -->
    <div class="actions">
        <a href="addmoney.php">
            <div class="action-btn">Add Money</div>
        </a>
        <a href="cashout.php">
            <div class="action-btn">Cashout</div>
        </a>
        <a href="transfermoney.php">
            <div class="action-btn">Transfer Money</div>
        </a>
    </div>

   
</div>


    <!-- functionalities -->

    <script src="scripts/main.js"></script>
    <script src="scripts/ajax.js"></script>
</body>

</html>