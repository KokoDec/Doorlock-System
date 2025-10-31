<?php
$conn = new mysqli("localhost", "root", "", "project3rd_db");
if ($conn->connect_error) die("DB error");

if (!isset($_POST['password'])) {
    echo "NO PASSWORD";
    exit;
}
$pass = $_POST['password'];
$stmt = $conn->prepare("INSERT INTO access_logs (password, status) VALUES (?, 'pending')");
$stmt->bind_param("s", $pass);
$stmt->execute();
echo "Request Sent";
?>