

document.getElementById("form").addEventListener("submit", function(event) {
    // Get form field values
    const phone = document.getElementById("phone").value.trim();
    const pin = document.getElementById("pin").value.trim();

    // Initialize an empty error message
    let errorMessage = "";

    // Phone number validation
    if (!phone || phone.length < 11) {
        errorMessage += "Please enter a valid phone number.\n";
    }

    // PIN validation (ensure it's 4 digits)
    if (!pin || !/^\d{4}$/.test(pin)) {
        errorMessage += "Please enter a valid 4-digit PIN.\n";
    }

    // If there are errors, prevent form submission and display the errors
    if (errorMessage) {
        alert(errorMessage);
        event.preventDefault(); // Stop form submission
    }
});































// <script>
//   // Function to allow only numeric input
//   document.getElementById("pin").addEventListener("input", function (event) {
//     this.value = this.value.replace(/\D/g, ''); // Remove any non-numeric characters
//   });

//   document.getElementById("confirm-pin").addEventListener("input", function (event) {
//     this.value = this.value.replace(/\D/g, ''); // Remove any non-numeric characters
//   });
// </script>


// document.getElementById("form").addEventListener("submit", function(event) {
//     var pin = document.getElementById("pin").value;
//     var confirmPin = document.getElementById("confirm-pin").value;
  
//     if (!/^\d{4}$/.test(pin) || pin !== confirmPin) {
//       alert("Please enter a valid 4-digit pin and make sure both fields match.");
//       event.preventDefault(); // Prevent form submission
//     }
//   });
  