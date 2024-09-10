<?php
session_start();

// Check if the user is logged in
if (empty($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Check if the user is not an admin
if ($_SESSION['permission'] == 1) {
    header("Location: admin_dashboard.php"); // Redirect admins to admin dashboard
    exit();
}
?>
