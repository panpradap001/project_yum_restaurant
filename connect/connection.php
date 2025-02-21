<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'sql303.infinityfree.com';
$user = 'if0_38248891';
$pass = 'panpradap007'; // ใส่รหัสจริง
$db = 'if0_38248891_myFirstDB';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตั้งค่าให้ใช้ UTF-8
$conn->set_charset("utf8mb4");
?>
