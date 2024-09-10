<?php 
include("./components/header.ini.php");
require('./middlewares/LoginOnly.php');

// Database connection
$conn = mysqli_connect("localhost", "root", "12345678", "webphp");

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Product not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = intval($_POST['quantity']);
    $total_price = $product['price'] * $quantity;
    $user_id = $_SESSION['user_id'];
    $order_date = date('Y-m-d H:i:s');
    $status = 'Pending';

    // Insert order into the database
    $sql = "INSERT INTO orders (user_id, product_id, quantity, total_price, order_date, status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'iiidss', $user_id, $product_id, $quantity, $total_price, $order_date, $status);
    mysqli_stmt_execute($stmt);

    // Redirect to a confirmation page
    header("Location: confirmation.php");  // Replace with your desired page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Product</title>
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
        }

        .container h2 {
            margin-top: 0;
            color: #007bff;
        }

        .product-details {
            text-align: center;
            margin-bottom: 20px;
        }

        .product-details img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .product-details h3 {
            margin: 10px 0;
            font-size: 24px;
            color: #333;
        }

        .product-details p {
            font-size: 16px;
            color: #666;
        }

        .product-details .price {
            font-size: 24px;
            color: #28a745;
            margin: 10px 0;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        form div {
            margin-bottom: 15px;
        }

        form label {
            display: block;
            font-size: 16px;
            color: #333;
            margin-bottom: 5px;
        }

        form input[type="number"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        form button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        form button:hover {
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
        <h2>Purchase Product</h2>
        <div class="product-details">
            <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <div class="price">$<?php echo htmlspecialchars($product['price']); ?></div>
        </div>

        <form method="post" action="">
            <div>
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="1" required>
            </div>
            <div>
                <button type="submit">Purchase</button>
            </div>
        </form>
    </div>

    <?php include("./components/footer.ini.php"); ?>
</body>
</html>
