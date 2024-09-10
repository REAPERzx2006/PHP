<?php 
include("./components/header.ini.php");
require('./middlewares/LoginOnly.php');

// Check if a product ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Product ID is missing.');
}

$productId = intval($_GET['id']);

// Fetch the product details from the database
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $productId);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    die('Product not found.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $image = $_FILES['image'];

    // Handle image upload
    $imageName = $product['image'];
    if ($image['error'] == UPLOAD_ERR_OK) {
        $dir = "images/";
        $imageName = uniqid() . '_' . mt_rand(1000, 9999) . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
        move_uploaded_file($image['tmp_name'], $dir . $imageName);
        // Remove old image if necessary
        if ($product['image'] && file_exists($dir . $product['image'])) {
            unlink($dir . $product['image']);
        }
    }

    // Update product details in the database
    $sql = "UPDATE products SET name = ?, description = ?, price = ?, stock_quantity = ?, image = ?, updated_at = NOW() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssdisi', $name, $description, $price, $stock_quantity, $imageName, $productId);
    $stmt->execute();

    header("Location: product_list.php"); // Redirect to product listing page
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 15px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group img {
            max-width: 200px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Product</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($product['description']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" step="0.01" value="<?= htmlspecialchars($product['price']) ?>" required>
            </div>
            <div class="form-group">
                <label for="stock_quantity">Stock Quantity</label>
                <input type="number" id="stock_quantity" name="stock_quantity" value="<?= htmlspecialchars($product['stock_quantity']) ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Product Image</label>
                <?php if ($product['image']): ?>
                    <img src="images/<?= htmlspecialchars($product['image']) ?>" alt="Current Image">
                <?php endif; ?>
                <input type="file" id="image" name="image">
            </div>
            <input type="submit" value="Update Product">
        </form>
        <a href="product_list.php">Back to Product List</a>
    </div>
</body>
</html>
