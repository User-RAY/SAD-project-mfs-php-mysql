<?php
session_start();
include "scripts/connect.php"; // Assuming this contains the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $phone = $_SESSION["phone"]; // Get the user's phone from session

    // Validate the input amount to ensure it's a positive number
    if ($amount <= 0) {
        $_SESSION["error_message"] = "Amount must be a positive number.";
    } else {
        $dbCon = getDbCon();
        // Insert logic to add money to the user's balance
        $stmt = $dbCon->prepare("UPDATE users SET balance = balance + ? WHERE phone = ?");
        $stmt->bind_param("ds", $amount, $phone); // d for double, s for string
        if ($stmt->execute()) {
            $_SESSION["success_message"] = "Money added successfully!";
        } else {
            $_SESSION["error_message"] = "Failed to add money.";
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
    <title>Add Money</title>
    <link rel="stylesheet" href="styles/action.css">
</head>

<body>
    <h1>Add Money</h1>
    
    <div>
        <?php
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
        <input type="number" id="amount" name="amount" step="0.01" required>
        <input type="submit" value="Add Money">
    </form>
    <a href="home.php">Back to Home</a>
</body>

</html>
