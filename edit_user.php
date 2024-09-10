<?php 
include("./components/header.ini.php");
require('./middlewares/LoginOnly.php');

// Check if the user has admin permissions
if ($_SESSION['permission'] != 1) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    // Fetch user data from the database
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <a href="admin_dashboard.php" class="logout-button">Back to Dashboard</a>

    <h1>Edit User</h1>

    <form action="update_user.php" method="post">
        <input type="hidden" name="id" value="<?=htmlspecialchars($user['id'])?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?=htmlspecialchars($user['name'])?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?=htmlspecialchars($user['email'])?>" required>
        
        <label for="permission">Role:</label>
        <select id="permission" name="permission">
            <option value="1" <?= $user['permission'] == 1 ? 'selected' : '' ?>>Admin</option>
            <option value="0" <?= $user['permission'] == 0 ? 'selected' : '' ?>>User</option>
        </select>
        
        <button type="submit">Update User</button>
    </form>
</body>
</html>
