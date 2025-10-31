<!DOCTYPE html>
<html>
<head>
  <title>Door Lock System</title>
</head>
<body>
  <h2>Pending Requests</h2>
  <?php
  $conn = new mysqli("localhost", "root", "", "project3rd_db");
  if ($conn->connect_error) die("DB error");

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $id = $_POST['id'];
      $action = $_POST['action'];
      $stmt = $conn->prepare("UPDATE access_logs SET status=?, decision_time=NOW() WHERE id=?");
      $stmt->bind_param("si", $action, $id);
      $stmt->execute();
      echo "<p>Request updated!</p>";
  }

  $result = $conn->query("SELECT * FROM access_logs WHERE status='pending'");
  while ($row = $result->fetch_assoc()) {
      echo "<form method='POST'>";
      echo "ID: " . $row['id'] . " | Password: " . $row['password'] . " | Time: " . $row['request_time'];
      echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
      echo "<button name='action' value='approved'>Yes</button>";
      echo "<button name='action' value='denied'>No</button>";
      echo "</form><br>";
  }
  ?>
</body>
</html>