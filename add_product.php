<?php 
include("./components/header.ini.php");
require('./middlewares/LoginOnly.php');

// ตรวจสอบสิทธิ์ผู้ใช้ (ต้องเป็นผู้ดูแลระบบ)
if ($_SESSION['permission'] != 1) {
    header("Location: product_listing.php");
    exit();
}

// การจัดการการส่งข้อมูลฟอร์ม
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    
    // การจัดการการอัปโหลดไฟล์
    $image = $_FILES['image']['name'];
    $target = "images/" . basename($image);

    // ตรวจสอบข้อมูลให้ครบถ้วน
    if (!empty($name) && !empty($description) && !empty($price) && !empty($image)) {
        // เพิ่มสินค้าใหม่ลงในฐานข้อมูล
        $sql = "INSERT INTO products (name, description, price, image) VALUES ('$name', '$description', '$price', '$image')";
        if (mysqli_query($conn, $sql)) {
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
            echo "<p>Product added successfully!</p>";
        } else {
            echo "<p>Error: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p>All fields are required.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <style>
        /* เพิ่มสไตล์ให้กับฟอร์ม */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            margin-top: 0;
        }

        .form-container label {
            display: block;
            margin: 10px 0 5px;
        }

        .form-container input,
        .form-container textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .form-container input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 15px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add New Product</h2>
        <form action="add_product.php" method="post" enctype="multipart/form-data">
            <label for="name">Product Name</label>
            <input type="text" id="name" name="name" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <label for="price">Price</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <label for="image">Image</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <input type="submit" value="Add Product">
        </form>
    </div>

    <?php include("./components/footer.ini.php"); ?>
</body>
</html>
