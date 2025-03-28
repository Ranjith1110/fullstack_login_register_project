<?php

session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header("Location: index.php"); // Redirect to the login page
exit(); // Ensure no further code is executed after the redirect
// Include your database connection file if needed

?>