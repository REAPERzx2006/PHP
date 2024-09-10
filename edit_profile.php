<?php include("./components/header.ini.php"); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['id'];
    $name = $_POST['name'];
    $image = $_FILES['image'];
    $_image = $_SESSION['image'];

    // Delete old image if exists
    if (!empty($_image)) {
        unlink("images/$_image");
    }

    $dir = "images/";
    $imageName = uniqid() . '_' . mt_rand(1000, 9999);
    $imageExtens = pathinfo($image['name'], PATHINFO_EXTENSION);
    $imageFullname = $imageName . "." . $imageExtens;

    if (move_uploaded_file($image["tmp_name"], $dir . $imageFullname)) {
        $sql = "UPDATE users SET name = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $name, $imageFullname, $userId);

        if ($stmt->execute()) {
            $_SESSION['name'] = $name;
            $_SESSION['image'] = $imageFullname;

            header("Location: index.php");
            exit();
        } else {
            echo "ERROR: " . mysqli_error($conn);
        }
        $stmt->close();
    } else {
        echo "Failed to upload image. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        .form-container img {
            display: block;
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="file"],
        input[type="submit"] {
            width: calc(100% - 22px);
            padding: 12px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        input[type="submit"] {
            background: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background: #0056b3;
        }
        a {
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form method="POST" enctype="multipart/form-data">
            <img src="images/<?=$_SESSION['image']?>" alt="Profile Image">
            <input type="file" name="image">
            <input type="text" placeholder="Email" disabled value="<?= htmlspecialchars($_SESSION['email']) ?>" name="email">
            <input type="text" placeholder="Name" value="<?= htmlspecialchars($_SESSION['name']) ?>" name="name">
            <input type="submit" value="Save">
            <a href="index.php">Go Back</a>
        </form>
    </div>
</body>
</html>

<?php include("./components/footer.ini.php") ?>
