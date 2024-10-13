<?php
session_start();
include "scripts/connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $recipientPhone = $_POST['recipient_phone'];
    $senderPhone = $_SESSION["phone"]; // Get the sender's phone from session

    // Validate the transfer amount
    if ($amount <= 0) {
        $_SESSION["error_message"] = "Please enter a valid positive amount.";
        header("Location: transfermoney.php");
        exit;
    }

    // Check if the sender is trying to transfer to themselves
    if ($senderPhone === $recipientPhone) {
        $_SESSION["error_message"] = "You cannot transfer money to yourself.";
        header("Location: transfermoney.php");
        exit;
    }

    $dbCon = getDbCon();

    // First, check if the recipient exists
    $stmt = $dbCon->prepare("SELECT phone FROM users WHERE phone = ?");
    $stmt->bind_param("s", $recipientPhone);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        // Recipient does not exist
        $_SESSION["error_message"] = "No user found with the provided phone number.";
    } else {
        // Perform the money transfer inside a transaction
        $dbCon->begin_transaction();
        try {
            // Subtract from sender if they have enough balance
            $stmt = $dbCon->prepare("UPDATE users SET balance = balance - ? WHERE phone = ? AND balance >= ?");
            $stmt->bind_param("dsd", $amount, $senderPhone, $amount);
            $stmt->execute();

            if ($stmt->affected_rows === 0) {
                throw new Exception("Insufficient balance for the transfer.");
            }

            // Add to recipient
            $stmt = $dbCon->prepare("UPDATE users SET balance = balance + ? WHERE phone = ?");
            $stmt->bind_param("ds", $amount, $recipientPhone);
            $stmt->execute();

            $dbCon->commit(); // Commit the transaction
            $_SESSION["success_message"] = "Transfer successful!";
        } catch (Exception $e) {
            $dbCon->rollback(); // Rollback the transaction in case of failure
            $_SESSION["error_message"] = "Transfer failed: " . $e->getMessage();
        }
    }
    $stmt->close();
    header("Location: transfermoney.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Money</title>
    <link rel="stylesheet" href="styles/action.css">
</head>

<body>
    <h1>Transfer Money</h1>

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
        <label for="recipient_phone">Recipient Phone:</label>
        <input type="text" id="recipient_phone" name="recipient_phone" required>
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" required>
        <input type="submit" value="Transfer">
    </form>
    <a href="home.php">Back to Home</a>
</body>

</html>
