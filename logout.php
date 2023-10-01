<?php
session_start(); // Start the session if it's not already started

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: login.html");
exit;
?>
