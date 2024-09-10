<?php
include("./components/header.ini.php");
require('./middlewares/LoginOnly.php');

// Check if the user is an admin
if ($_SESSION['permission'] != 1) {
    header("HTTP/1.1 403 Forbidden");
    exit();
}

// Database connection
$conn = mysqli_connect("localhost", "root", "12345678", "webphp");

// Get data from POST request
$order_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$status = isset($_POST['status']) ? $_POST['status'] : '';

// Validate status
$valid_statuses = ['Pending', 'Shipped', 'Delivered', 'Cancelled'];
if (!in_array($status, $valid_statuses)) {
    header("HTTP/1.1 400 Bad Request");
    exit();
}

// Update order status
$sql = "UPDATE orders SET status = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'si', $status, $order_id);
mysqli_stmt_execute($stmt);

// Check if the update was successful
if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "Status updated successfully.";
} else {
    header("HTTP/1.1 500 Internal Server Error");
}
?>
