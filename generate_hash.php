<?php
// The password to hash
$password = "1234";

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Print the hashed password
echo $hashed_password;
?>
