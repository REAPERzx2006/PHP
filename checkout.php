<?php
session_start();

if (empty($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Handle checkout process here (e.g., create an order, clear cart, etc.)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        /* Add some basic styles here */
    </style>
</head>
<body>
    <h1>Checkout</h1>
    <!-- Add checkout form and payment handling here -->
    
    <a href="index.php">Back to Product Listing</a>
</body>
</html>
