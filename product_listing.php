<?php 
include("./components/header.ini.php");
require('./middlewares/LoginOnly.php');

// Database connection
$conn = mysqli_connect("localhost", "root", "12345678", "webphp");

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
    <style>
        /* Basic styles for product listing */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .product-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: calc(33.333% - 20px);
            box-sizing: border-box;
            padding: 10px;
            text-align: center;
        }

        .product-card img {
            max-width: 100%;
            height: auto;
            object-fit: cover;
        }

        .product-card h3 {
            font-size: 18px;
            margin: 10px 0;
        }

        .product-card p {
            font-size: 16px;
            color: #666;
        }

        .product-card .price {
            font-size: 20px;
            color: #007bff;
            margin: 10px 0;
        }

        .product-card form {
            margin-top: 10px;
        }

        .product-card button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .product-card button:hover {
            background-color: #218838;
        }

        .product-card .remove {
            background-color: #dc3545;
        }

        .product-card .remove:hover {
            background-color: #c82333;
        }

        .cart-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 15px 20px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .cart-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Product Listing</h2>
        <div class="product-container">
            <?php while ($product = mysqli_fetch_assoc($result)): ?>
                <div class="product-card">
                    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <div class="price">$<?php echo htmlspecialchars($product['price']); ?></div>
                    
                    <?php if (isset($_SESSION['cart'][$product['id']])): ?>
                        <!-- Remove from Cart Button -->
                        <form method="post" action="add_to_cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="hidden" name="action" value="remove">
                            <button type="submit" class="remove">Remove from Cart</button>
                        </form>
                    <?php else: ?>
                        <!-- Add to Cart Button -->
                        <form method="post" action="add_to_cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit">Add to Cart</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <a href="view_cart.php" class="cart-button">View Cart</a>
    
    <?php include("./components/footer.ini.php"); ?>
</body>
</html>
