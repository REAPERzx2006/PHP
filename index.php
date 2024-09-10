<?php 
include("./components/header.ini.php");
require('./middlewares/LoginOnly.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
            min-height: 100vh;
            background-color: #f9f9f9;
        }

        .profile-container {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .profile-container img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }

        .profile-container .profile-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .profile-container .profile-info a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
            margin-top: 5px;
        }

        .profile-container .profile-info a:hover {
            text-decoration: underline;
        }

        .product-container {
            margin: 80px 20px 20px; /* Margin to ensure space for profile-container */
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

        .action-buttons {
            margin-top: 20px;
        }

        .action-buttons a {
            display: inline-block;
            margin-right: 10px;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
        }

        .action-buttons a:hover {
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

        .dashboard-buttons {
            margin: 20px;
            display: flex;
            gap: 10px;
            flex-direction: column;
        }

        .dashboard-buttons a {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            text-align: center;
        }

        .dashboard-buttons a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <a href="logout.php" class="logout-button">Logout</a>

    <div class="profile-container">
        <img src="images/<?=$_SESSION['image']?>" alt="Profile Image">
        <div class="profile-info">
            <span><?=$_SESSION['name']?></span>
            <a href="edit_profile.php">Edit Profile</a>
            <?php if ($_SESSION['permission'] == 1): ?>
                <a href="add_product.php">Add Product</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Dashboard buttons -->
    <div class="dashboard-buttons">
        <?php if ($_SESSION['permission'] == 1): ?>
            <a href="admin_dashboard.php">Admin Dashboard</a>
            <a href="edit_order.php">Edit Orders</a>
        <?php else: ?>
            <a href="user_dashboard.php">User Dashboard</a>
        <?php endif; ?>
    </div>

    <?php if ($_SESSION['permission'] == 1): ?>
        <div class="action-buttons">
            <a href="add_product.php">Add New Product</a>
        </div>
    <?php endif; ?>

    <div class="product-container">
        <?php
        // Fetch and display products
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);

        while ($product = mysqli_fetch_assoc($result)) {
            echo '<div class="product-card">';
            echo '<img src="images/' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '">';
            echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
            echo '<p>' . htmlspecialchars($product['description']) . '</p>';
            echo '<div class="price">$' . htmlspecialchars($product['price']) . '</div>';

            // Display purchase button for non-admins
            if ($_SESSION['permission'] == 0) {
                echo '<button onclick="location.href=\'purchase.php?id=' . $product['id'] . '\'">Buy Now</button>';
            } else {
                echo '<button onclick="location.href=\'edit_product.php?id=' . $product['id'] . '\'">Edit</button>';
            }

            echo '</div>';
        }
        ?>
    </div>

    <?php include("./components/footer.ini.php"); ?>
</body>
</html>
