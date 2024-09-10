<?php
include("./components/header.ini.php");
require('./middlewares/NoLogin.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST["email"];
    $name = $_POST["name"];
    $password = $_POST["password"];
    $image = $_FILES["image"];

    $dir = "images/";
    $imageName = uniqid() . '_' . mt_rand(1000, 9999);
    $imageExtens = pathinfo($image['name'], PATHINFO_EXTENSION);
    $imageFullname = $imageName . "." . $imageExtens;

    // Validate email and password (basic example, extend as needed)
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $error_message = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters long.";
    } else {
        if (move_uploaded_file($image["tmp_name"], $dir . $imageFullname)) {
            // Prepare and execute the SQL query
            $stmt = $conn->prepare("INSERT INTO users (email, name, password, image) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $email, $name, $password, $imageFullname);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                if (mysqli_errno($conn) == 1062) {
                    $error_message = "This email is already in use.";
                } else {
                    $error_message = "Please try again later.";
                }
            }
            $stmt->close();
        } else {
            $error_message = "Failed to upload image. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            border: 1px solid #ddd;
            transition: box-shadow 0.3s ease, border-color 0.3s ease;
        }

        .form-container:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            border-color: #007bff;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }

        input[type="text"],
        input[type="password"],
        input[type="file"],
        input[type="submit"] {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 10px auto;
            border: 1px solid #ced4da;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="submit"] {
            background: #007bff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }

        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form method="POST" enctype="multipart/form-data">
            <h2>Register</h2>
            <input type="text" placeholder="Email" name="email" required>
            <input type="text" placeholder="Name" name="name" required>
            <input type="password" placeholder="Password" name="password" required>
            <input type="file" name="image" accept="image/*" required>
            <input type="submit" value="Register">
            <?php
            if (isset($error_message)) {
                echo "<div class='error'>$error_message</div>";
            }
            ?>
        </form>
    </div>
</body>
</html>

<?php include("./components/footer.ini.php") ?>
