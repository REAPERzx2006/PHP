
<?php 
include("./components/header.ini.php");
require('./middlewares/LoginOnly.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        /* Your existing styles plus any new styles for user dashboard */
        .user-dashboard-container {
            margin: 20px;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        
        .user-dashboard-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        
        .user-dashboard-container a {
            display: inline-block;
            margin-right: 10px;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
        }

        .user-dashboard-container a:hover {
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

    <div class="user-dashboard-container">
        <h1>User Dashboard</h1>
        <a href="view_orders.php">View Orders</a>
        <a href="view_cart.php">View Cart</a>
        <a href="edit_profile.php">Edit Profile</a>
    </div>

    <?php include("./components/footer.ini.php"); ?>
</body>
</html>
