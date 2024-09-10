<?php 
include("./components/header.ini.php");
require('./middlewares/LoginOnly.php');

// Database connection
$conn = mysqli_connect("localhost", "root", "12345678", "webphp");

// Check if the order ID is available
if (!isset($_SESSION['last_order_id'])) {
    header("Location: product_listing.php");
    exit();
}

$order_id = $_SESSION['last_order_id'];

// Fetch order details
$sql = "SELECT orders.*, products.name as product_name, products.price as product_price
        FROM orders
        JOIN products ON orders.product_id = products.id
        WHERE orders.id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $order_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$order = mysqli_fetch_assoc($result);

if (!$order) {
    die("Order not found.");
}

// Clear the last order ID from the session
unset($_SESSION['last_order_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 90%;
            max-width: 600px;
            margin: 20px;
            box-sizing: border-box;
            text-align: center;
        }

        .container h2 {
            margin-top: 0;
            color: #28a745;
        }

        .order-details {
            margin-top: 20px;
            font-size: 16px;
            color: #333;
        }

        .order-details .detail {
            margin-bottom: 10px;
        }

        .order-details .detail span {
            font-weight: bold;
        }

        .buttons {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .buttons a, .buttons button {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            text-align: center;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .buttons a:hover, .buttons button:hover {
            background-color: #0056b3;
        }

        .logout-button {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <a href="logout.php" class="logout-button">Logout</a>

    <div class="container">
        <h2>Order Confirmation</h2>
        <div class="order-details">
            <div class="detail"><span>Order ID:</span> <?php echo htmlspecialchars($order['id']); ?></div>
            <div class="detail"><span>Product:</span> <?php echo htmlspecialchars($order['product_name']); ?></div>
            <div class="detail"><span>Quantity:</span> <?php echo htmlspecialchars($order['quantity']); ?></div>
            <div class="detail"><span>Total Price:</span> $<?php echo htmlspecialchars($order['total_price']); ?></div>
            <div class="detail"><span>Order Date:</span> <?php echo htmlspecialchars(date('Y-m-d H:i:s', strtotime($order['order_date']))); ?></div>
            <div class="detail"><span>Status:</span> <?php echo htmlspecialchars($order['status']); ?></div>
        </div>

        <div class="buttons">
            <a href="product_listing.php">Continue Shopping</a>
            <a href="view_orders.php">View Order History</a>
        </div>
    </div>

    <?php include("./components/footer.ini.php"); ?>
</body>
</html>
