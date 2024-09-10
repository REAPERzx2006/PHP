<?php 
include("./components/header.ini.php");
require('./middlewares/LoginOnly.php');

// Check if the user is an admin
if ($_SESSION['permission'] != 1) {
    header("Location: product_listing.php");
    exit();
}

// Database connection
$conn = mysqli_connect("localhost", "root", "12345678", "webphp");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get order ID from URL
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch order details
$sql = "SELECT orders.id, orders.user_id, orders.product_id, orders.quantity, orders.total_price, orders.order_date, orders.status,
        users.name as user_name, products.name as product_name
        FROM orders
        JOIN users ON orders.user_id = users.id
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];

    // Update order status
    $sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'si', $status, $order_id);
    mysqli_stmt_execute($stmt);

    // Redirect to view orders page
    header("Location: view_orders.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 20px;
        }

        form div {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
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
        <h2>Edit Order</h2>
        <form method="post" action="">
            <div>
                <label for="order_id">Order ID:</label>
                <input type="text" id="order_id" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>" readonly>
            </div>
            <div>
                <label for="user_name">User:</label>
                <input type="text" id="user_name" value="<?php echo htmlspecialchars($order['user_name']); ?>" readonly>
            </div>
            <div>
                <label for="product_name">Product:</label>
                <input type="text" id="product_name" value="<?php echo htmlspecialchars($order['product_name']); ?>" readonly>
            </div>
            <div>
                <label for="quantity">Quantity:</label>
                <input type="text" id="quantity" value="<?php echo htmlspecialchars($order['quantity']); ?>" readonly>
            </div>
            <div>
                <label for="total_price">Total Price:</label>
                <input type="text" id="total_price" value="$<?php echo htmlspecialchars($order['total_price']); ?>" readonly>
            </div>
            <div>
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="Pending" <?php if ($order['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Shipped" <?php if ($order['status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
                    <option value="Delivered" <?php if ($order['status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                    <option value="Cancelled" <?php if ($order['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                </select>
            </div>
            <div>
                <button type="submit">Update Status</button>
            </div>
        </form>
    </div>

    <?php include("./components/footer.ini.php"); ?>
</body>
</html>
