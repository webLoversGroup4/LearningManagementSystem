<?php
// Start session
session_start();

// Destroy session data and unset $_SESSION variable on server
session_destroy();
unset($_SESSION['user_id']);
header("Location: ../login/login.php");

exit();
