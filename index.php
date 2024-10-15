<?php
session_start();


if(isset($_SESSION["phone"])){

    header("location: home.php");

}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'];
    $pin = $_POST['pin'];

    

    // If validation passes, proceed with database query
    include "scripts/connect.php";
    $dbCon = getDbCon();

    $stmt = $dbCon->prepare("SELECT phone, pin FROM users WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $stmt->bind_result($stored_phone, $stored_pin);

    // fetch values
    if ($stmt->fetch()) {
        if ($pin == $stored_pin) {
            // Phone and PIN match, start session and redirect to home page
            $_SESSION["phone"] = $phone;
            header("location: /sad/home.php");
            exit;
        } else {
            // If PIN is incorrect
            $_SESSION["error_message"] = "Invalid phone number or PIN. Please try again.";
            header("location: /sad/index.php");
            exit;
        }
    } else {
        // If phone number is not found
        $_SESSION["error_message"] = "Invalid phone number or PIN. Please try again.";
        header("location: /sad/index.php");
        exit;
    }

    $stmt->close();
    $dbCon->close();
}



?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batash</title>


    <!-- CUSTOM CSS STYLES -->
    <link rel="stylesheet" href="styles/class.css">
    <link rel="stylesheet" href="styles/style.css">

</head>

<body class="min-h-screen flex flex-col">
    


    <main class="my-auto main">
        <div class="">
    
            <div class="flex justify-center items-center flex-col">
                <img src="assets/logo/fina.gif" alt="logo" class="w-50">
                <div class="tagline">
                    <span class="highlight">Exchange Far, Exchange Fast,</span> like Batash with <span><img src="assets/logo/BATASH.png" alt="" class="w-12"></span>
                  </div>                 
            </div>
            
            <div>
            <?php
            // Start session to check for error message


            // Check if there's an error message
            if (isset($_SESSION["error_message"])) {
                echo '<p style="color: red;">' . $_SESSION["error_message"] . '</p>';
                // Clear the error message after displaying it
                unset($_SESSION["error_message"]);
            }
            ?>
            </div>

            <div id="form-box" class="border border-solid color-blue">
                <form method="POST" id="form" class="flex flex-col p-12 justify-center items-center">
                    <label for="phone" class="">Mobile Number</label>
                    <input type="number" placeholder="Type here" id="phone" name="phone" class="input input-bordered input-primary w-full max-w-xs my-2" required/>
                    <label for="pin" class="mt-2">4-digit Pin</label>
                    <input type="password" placeholder="Type here" id="pin" name="pin" class="input input-bordered input-primary w-full max-w-xs my-2" nputmode="numeric" pattern="[0-9]*" maxlength="4" minlength="4" required/>
                    <input type="submit" value="Log In" class="input input-bordered input-primary w-full max-w-xs mt-4">
                </form>
            </div>
        </div>

        <p class="text-center mt-4"> Don't have account. Create new accout:<a href="register.php"> Register </a></p>

    </main>



    <!-- functionalities -->

    <script src="scripts/main.js"></script>
    <script src="scripts/ajax.js"></script>
</body>

</html>