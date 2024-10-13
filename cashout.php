<?php
session_start();
include "scripts/connect.php";

// Check if the user is logged in
if (!isset($_SESSION['phone'])) {
    header("Location: login.php");  // Redirect to login if user is not logged in
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $phone = $_SESSION["phone"]; // Get the user's phone from session

    // Validate amount
    if ($amount <= 0) {
        $_SESSION["error_message"] = "Invalid amount. Please enter a positive value.";
    } else {
        // Insert logic to cashout the user's balance
        $dbCon = getDbCon();
        $stmt = $dbCon->prepare("UPDATE users SET balance = balance - ? WHERE phone = ? AND balance >= ?");
        $stmt->bind_param("dsd", $amount, $phone, $amount); // d for double, s for string
        
        if ($stmt->execute() && $stmt->affected_rows > 0) {
            $_SESSION["success_message"] = "Cashout successful!";
        } else {
            $_SESSION["error_message"] = "Insufficient balance or cashout failed.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashout</title>
    <link rel="stylesheet" href="styles/action.css">
</head>

<body>
    <h1>Cashout</h1>

    <div>
        <?php
        // Display success or error messages
        if (isset($_SESSION["success_message"])) {
            echo '<p style="color: green;">' . $_SESSION["success_message"] . '</p>';
            unset($_SESSION["success_message"]);
        }
        if (isset($_SESSION["error_message"])) {
            echo '<p style="color: red;">' . $_SESSION["error_message"] . '</p>';
            unset($_SESSION["error_message"]);
        }
        ?>
    </div>

    <form method="POST">
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" min="0.01" required>
        <input type="submit" value="Cashout">
    </form>
    
    <a href="home.php">Back to Home</a>
</body>

</html>
