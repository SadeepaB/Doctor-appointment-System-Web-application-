<?php
session_start(); // Start or resume the session

// Destroy the session to log out the user
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session

// Redirect to the login page or home page
header("Location: login.php"); // Change this to the page you want to redirect to
exit();
?>