<?php 
include("./components/header.ini.php");
require('./middlewares/AdminOnly.php'); // Ensure only admins can access this page
include('./db_connection.php'); // Make sure you have this to connect to your database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .header, .footer {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        .header a, .footer a {
            color: #fff;
            text-decoration: none;
        }

        .header a:hover, .footer a:hover {
            text-decoration: underline;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px;
        }

        .user-table th, .user-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .user-table th {
            background-color: #007bff;
            color: #fff;
        }

        .user-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .delete-button {
            color: #dc3545;
            text-decoration: none;
        }

        .delete-button:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="index.php">Home</a> | 
        <a href="user_dashboard.php">User Dashboard</a> | 
        <a href="admin_dashboard.php">Admin Dashboard</a>
    </div>

    <h1 style="text-align: center; margin-top: 20px;">Manage Users</h1>

    <table class="user-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Handle user deletion
            if (isset($_GET['delete'])) {
                $userId = intval($_GET['delete']);
                $deleteSql = "DELETE FROM users WHERE id = $userId";
                if (mysqli_query($conn, $deleteSql)) {
                    echo "<script>alert('User deleted successfully.'); window.location.href = 'manage_users.php';</script>";
                } else {
                    echo "<script>alert('Error deleting user.');</script>";
                }
            }

            // Fetch and display users
            $sql = "SELECT * FROM users";
            $result = mysqli_query($conn, $sql);

            while ($user = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($user['id']) . '</td>';
                echo '<td>' . htmlspecialchars($user['name']) . '</td>';
                echo '<td>' . htmlspecialchars($user['email']) . '</td>';
                echo '<td><a href="?delete=' . $user['id'] . '" class="delete-button">Delete</a></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

    <div class="footer">
        &copy; <?= date("Y"); ?> Your Company. All Rights Reserved.
    </div>

    <?php include("./components/footer.ini.php"); ?>
</body>
</html>
