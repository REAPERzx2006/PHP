<?php
session_start();

if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    
    // Check if action is to add or remove from cart
    if (isset($_POST['action']) && $_POST['action'] == 'remove') {
        // Remove product from cart
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
    } else {
        // Add product to cart
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = 1;  // Default quantity 1
        }
    }

    // Redirect back to the product listing or cart page
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
