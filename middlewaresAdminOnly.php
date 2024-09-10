<?php
session_start();

if (!isset($_SESSION['permission']) || $_SESSION['permission'] != 1) {
    // Redirect to user dashboard or an error page
    header("Location: user_dashboard.php");
    exit();
}
?>
