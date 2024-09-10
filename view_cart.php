<?php
session_start();

// Check if the cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty.";
    exit();
}

// Database connection
$conn = mysqli_connect("localhost", "root", "12345678", "webphp");

// Fetch product details for items in the cart
$cartItems = array_keys($_SESSION['cart']);
$placeholders = implode(',', array_fill(0, count($cartItems), '?'));

$stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
$stmt->bind_param(str_repeat('i', count($cartItems)), ...$cartItems);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #007bff; color: white; }
        .remove-button { background-color: #dc3545; color: white; padding: 5px 10px; border: none; cursor: pointer; }
        .remove-button:hover { background-color: #c82333; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Cart</h2>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td>$<?php echo htmlspecialchars(number_format($product['price'], 2)); ?></td>
                        <td><?php echo htmlspecialchars($_SESSION['cart'][$product['id']]); ?></td>
                        <td>
                            <form method="post" action="add_to_cart.php">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <input type="hidden" name="action" value="remove">
                                <button type="submit" class="remove-button">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
