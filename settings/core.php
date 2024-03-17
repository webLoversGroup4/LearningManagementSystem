<?php

// Function to check login status
function checkLogin()
{
    // Checking if user ID cookie exists
    if (!isset($_COOKIE['user_id'])) {
        // Redirecting to login page
        header("Location: ../login/login.php");
        die();
    } else {
        // Update login status 
        header("Location: ../admin/dashboard.php");
        die();
    }
}

// Calling checkLogin function to ensure user is logged in before proceeding
checkLogin();
