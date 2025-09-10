<?php
$host = "localhost";
$user = "root";   // user mặc định của XAMPP
$pass = "12345678";       // thường XAMPP để rỗng
$db   = "jobfinder";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
