<?php 
    // Include constants.php here
    include('../config/constants.php');

    // Start a session to manage user sessions
    session_start();

    // Check if the user is already logged out
    if (!isset($_SESSION['user'])) {
        // If the user is not logged in, there's no need to log them out.
        header('location:'.SITEURL.'admin/login.php');
        exit; // Exit to prevent further execution
    }

    // If the user is logged in, proceed to log them out

    // 1. Destroy the session
    session_destroy();

    // 2. Unset all session variables
    $_SESSION = array();

    // 3. Redirect to the login page
    header('location:'.SITEURL.'admin/login.php');
    exit; // Exit to prevent further execution
?>
