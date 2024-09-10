<?php
include("./components/header.ini.php");
require('./middlewares/LoginOnly.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        /* Include necessary CSS here */
    </style>
</head>
<body>
    <a href="logout.php" class="logout-button">Logout</a>
    <a href="product_listing.php" class="action-buttons">Back to Products</a>

    <h1>Shopping Cart</h1>

    <?php
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        // Fetch cart items
        $cart_ids = implode(',', array_keys($_SESSION['cart']));
        $sql = "SELECT * FROM products WHERE id IN ($cart_ids)";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo '<table>';
            echo '<tr><th>Product</th><th>Quantity</th><th>Price</th><th>Total</th></tr>';
            $total = 0;

            while ($product = mysqli_fetch_assoc($result)) {
                $quantity = $_SESSION['cart'][$product['id']];
                $product_total = $product['price'] * $quantity;
                $total += $product_total;

                echo '<tr>';
                echo '<td>' . htmlspecialchars($product['name']) . '</td>';
                echo '<td>' . htmlspecialchars($quantity) . '</td>';
                echo '<td>$' . htmlspecialchars($product['price']) . '</td>';
                echo '<td>$' . htmlspecialchars($product_total) . '</td>';
                echo '</tr>';
            }

            echo '<tr><td colspan="3">Total</td><td>$' . htmlspecialchars($total) . '</td></tr>';
            echo '</table>';
        } else {
            echo '<p>Your cart is empty.</p>';
        }
    } else {
        echo '<p>Your cart is empty.</p>';
    }
    ?>

    <?php include("./components/footer.ini.php"); ?>
</body>
</html>
