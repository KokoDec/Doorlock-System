<?php
$conn = new mysqli("localhost", "root", "", "project3rd_db");
if ($conn->connect_error) die("DB error");

$result = $conn->query("SELECT * FROM access_logs WHERE status='pending' ORDER BY id DESC LIMIT 1");
if ($row = $result->fetch_assoc()) {
    echo $row['status'];
} else {
    echo "none";
}
?>