<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        td img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }

        select, input[type="submit"] {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        select {
            margin-right: 10px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        form {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>รูป</th>
                <th>ชื่อ</th>
                <th>คำสั่งซื้อ</th>
                <th>เครื่องมือ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $selfId = $_SESSION['id'];
            $sql = "SELECT * FROM users WHERE id != '$selfId'";
            $result = mysqli_query($conn, $sql);

            while ($data = mysqli_fetch_assoc($result)) {
                $target = $data['id'];
                $likedQuery = mysqli_query($conn, "SELECT rate FROM rating WHERE rateBy = '$selfId' AND rateTo = '$target'");
                $likeData = mysqli_fetch_assoc($likedQuery);
                $liked = isset($likeData['rate']) ? $likeData['rate'] : "-1";

                $likes_query = mysqli_query($conn, "SELECT AVG(rate) AS avg_rate FROM rating WHERE rateTo = '$target'");
                $likes_data = mysqli_fetch_assoc($likes_query);
                $likes = isset($likes_data['avg_rate']) ? round($likes_data['avg_rate'], 2) : "ไม่พบคำสั่งซื้อ";
            ?>
                <tr>
                    <td><img src="images/<?= htmlspecialchars($data['image']) ?>" alt="Profile Image"></td>
                    <td><?= htmlspecialchars($data['name']) ?></td>
                    <td><?= htmlspecialchars($likes) ?></td>
                    <td>
                        <form method="POST" action="./actions/rate.php">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">
                            <select name="rate">
                                <option value="1" <?= $liked == "1" ? "selected" : "" ?>>1</option>
                                <option value="2" <?= $liked == "2" ? "selected" : "" ?>>2</option>
                                <option value="3" <?= $liked == "3" ? "selected" : "" ?>>3</option>
                                <option value="4" <?= $liked == "4" ? "selected" : "" ?>>4</option>
                                <option value="5" <?= $liked == "5" ? "selected" : "" ?>>5</option>
                                <option value="-1" <?= $liked == "-1" ? "selected" : "" ?>>6</option>
                            </select>
                            <input type="submit" value="เพิ่มคำสั่งซื้อ">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
