<?php 
include("./components/header.ini.php");
require('./middlewares/AdminOnly.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Your existing styles plus any new styles for admin dashboard */
        .admin-dashboard-container {
            margin: 20px;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        
        .admin-dashboard-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        
        .admin-dashboard-container a {
            display: inline-block;
            margin-right: 10px;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
        }

        .admin-dashboard-container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="index.php">Home</a> | 
        <a href="user_dashboard.php">User Dashboard</a> | 
        <a href="admin_dashboard.php">Admin Dashboard</a>
    </div>

    <div class="admin-dashboard-container">
        <h1>Admin Dashboard</h1>
        <a href="manage_users.php">Manage Users</a>
        <a href="manage_products.php">Manage Products</a>
        <a href="view_orders.php">View Orders</a>
        <a href="view_cart.php">View Cart</a>
        <a href="site_settings.php">Site Settings</a>
    </div>

    <?php include("./components/footer.ini.php"); ?>
</body>
</html>