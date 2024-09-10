<?php
session_start();

// Check if the user is logged in
if (empty($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Check if the user is an admin
if ($_SESSION['permission'] != 1) {
    header("Location: user_dashboard.php"); // Redirect non-admins to user dashboard
    exit();
}
?>
