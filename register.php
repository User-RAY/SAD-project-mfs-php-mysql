<?php
    session_start();

    $authenticated = false;

    if(isset($_SESSION["phone"])){
        $authenticated = true;
        header("location: /home.php");
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

<body class=" flex flex-col">
    
<div class="">
    
        <main class="main">
    
    
                <div class="flex justify-center items-center flex-col p-4">
                    <img src="assets/logo/fina.gif" alt="logo" class="w-50">
                    <div class="tagline">
                        <span class="highlight">Exchange Far, Exchange Fast,</span> like Batash with <span><img src="assets/logo/BATASH.png" alt="" class="w-12"></span>
                      </div>
                </div>
    
                <div id="form-box" class="border border-solid color-blue">
                    <form action="scripts/db.php" method="POST" id="form" class="flex flex-col p-12 justify-center items-center">
                        <div class="flex items-center">
                            <div class="w-full mr-4">
                                <label for="name" class="">Full ID Name</label>
                                <input type="text" placeholder="Type here" id="name" name="name" class="input input-bordered input-primary w-full max-w-xs my-2" required/>
                            </div>
    
                            <div class="w-full">
                                <label for="nid" class="">7 digit ID Number</label>
                                <br>
                                <input type="number" placeholder="Type here" id="nid" name="nid" class="input input-bordered input-primary w-full max-w-xs my-2" required/>
                            </div>
                        </div>
                        <label for="phone" class="">Mobile Number</label>
                        <input type="number" placeholder="Type here" id="phone" name="phone" class="input input-bordered input-primary w-full max-w-xs my-2" required/>
                        <label for="pin" class="mt-2">4-digit Pin</label>
                        <input type="password" placeholder="Type here" id="pin" name="pin" class="input input-bordered input-primary w-full max-w-xs my-2" required/>
                        <label for="pin2" class="mt-2">Confirm 4-digit Pin</label>
                        <input type="password" placeholder="Type here" id="pin2" class="input input-bordered input-primary w-full max-w-xs my-2" required/>
                        <input type="submit" value="Register" class="input input-bordered input-primary w-full max-w-xs mt-4">
                    </form>
                </div>
    
            <p class="text-center"> Already have account. Log into your accout:<a href="index.php"> Login </a></p>
    
    
        </main>
</div>








    <!-- functionalities -->
    <script src="js/utilities.js"></script>
    <script src="js/main.js"></script>

    <script>
        document.getElementById("form").addEventListener("submit", function(event) {
    const name = document.getElementById("name").value;
    const nid = document.getElementById("nid").value;
    const phone = document.getElementById("phone").value;
    const pin = document.getElementById("pin").value;
    const pin2 = document.getElementById("pin2").value;

    // Clear any previous error messages
    let errorMessage = '';

    // Validate name (should not be empty and should have at least 2 characters)
    if (name.length < 2) {
        errorMessage += "Full Name should be at least 2 characters long.\n";
    }

    // Validate 7-digit ID (must be exactly 7 digits)
    if (nid.length !== 7 || isNaN(nid)) {
        errorMessage += "ID Number must be exactly 7 digits.\n";
    }

    // Validate phone number (must be at least 11 digits)
    if (phone.length < 11 || isNaN(phone)) {
        errorMessage += "Please enter a valid 11-digit phone number.\n";
    }

    // Validate PIN (must be exactly 4 digits)
    if (pin.length !== 4 || isNaN(pin)) {
        errorMessage += "PIN must be exactly 4 digits.\n";
    }

    // Check if PIN and Confirm PIN match
    if (pin !== pin2) {
        errorMessage += "PINs do not match.\n";
    }

    // If there are any validation errors, prevent form submission and alert the user
    if (errorMessage) {
        event.preventDefault();  // Prevent form submission
        alert(errorMessage);  // Show alert with all error messages
    }
});

    </script>
</body>

</html>