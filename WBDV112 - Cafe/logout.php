<?php
// Start the session
session_start();

// Destroy the session to log out the user
session_destroy();

// Redirect the user to the homepage after logout
header("Location: index.php");
exit();
?>
