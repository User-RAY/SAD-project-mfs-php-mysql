<?php
// logout.php
session_start();
$_SESSION = array();
session_destroy();  // End the session
header("Location: ../index.php");  // Redirect to the login page
exit;
?>
