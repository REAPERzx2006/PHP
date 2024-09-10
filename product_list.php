<?php 
include("./components/header.ini.php");
require('./middlewares/LoginOnly.php');

// Fetch all products from the database
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

// Check if there are products in the database
if (mysqli_num_rows($result) == 0) {
    echo "<p>No products found.</p>";
} else {
    // Display products in a table
    ?>
    <?php 
if (isset($_GET['message'])) {
    echo "<p style='color: green;'>".htmlspecialchars($_GET['message'])."</p>";
}
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product List</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f9f9f9;
            }

            .container {
                max-width: 1200px;
                margin: 20px auto;
                padding: 20px;
                background: #fff;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            th, td {
                border: 1px solid #ddd;
                padding: 10px;
                text-align: left;
            }

            th {
                background-color: #007bff;
                color: white;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            .action-buttons a {
                display: inline-block;
                padding: 6px 12px;
                margin-right: 5px;
                color: #fff;
                text-decoration: none;
                border-radius: 4px;
                font-size: 14px;
            }

            .action-buttons .edit {
                background-color: #007bff;
            }

            .action-buttons .edit:hover {
                background-color: #0056b3;
            }

            .action-buttons .delete {
                background-color: #dc3545;
            }

            .action-buttons .delete:hover {
                background-color: #c82333;
            }

            .action-buttons .delete {
                background-color: #dc3545;
            }

            .action-buttons .delete:hover {
                background-color: #c82333;
            }

            .btn-add {
                display: inline-block;
                padding: 10px 20px;
                background-color: #28a745;
                color: #fff;
                text-decoration: none;
                border-radius: 4px;
                font-size: 16px;
                margin-bottom: 20px;
            }

            .btn-add:hover {
                background-color: #218838;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Product List</h1>
            <a href="add_product.php" class="btn-add">Add New Product</a>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><img src="images/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" style="width: 100px; height: auto;"></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td>$<?= htmlspecialchars(number_format($row['price'], 2)) ?></td>
                            <td><?= htmlspecialchars($row['stock_quantity']) ?></td>
                            <td class="action-buttons">
                                <a href="edit_product.php?id=<?= $row['id'] ?>" class="edit">Edit</a>
                                <a href="delete_product.php?id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                

                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </body>
    </html>
    <?php
}
?>

<?php include("./components/footer.ini.php"); ?>
