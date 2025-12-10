<?php
// Start the session
session_start();

// Destroy all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: login.php"); // Or wherever your login page is located
exit();
?>
