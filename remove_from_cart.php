<?php
session_start();

// Check if the product ID is provided via POST
if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    
    // Remove the product from the cart if it exists
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
        
        // Redirect back to the cart with a success message
        header("Location: view_cart.php?message=Product removed from cart");
        exit();
    } else {
        // Redirect back to the cart with an error message
        header("Location: view_cart.php?message=Product not found in cart");
        exit();
    }
} else {
    // Redirect back to the cart if no product ID is provided
    header("Location: view_cart.php");
    exit();
}
