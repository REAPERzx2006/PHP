<?php
$host = "localhost";
$username = "root";
$password = "12345678";
$dbName = "webphp";

$conn = mysqli_connect($host, $username, $password, $dbName);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

session_start();