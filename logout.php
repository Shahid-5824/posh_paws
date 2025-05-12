<?php
session_start();  // Start session
session_destroy();  // Destroy all session data

// Redirect to the homepage
header("Location: index.php");
exit();
?>
