<?php
session_start();
require 'config.php';

if (isset($_POST['save'])) {
  $user_id = $_SESSION['user_id'];
  $name = trim($_POST['name']);
  $section = trim($_POST['section']);

  if (!empty($name) && !empty($section)) {
    $stmt = $conn->prepare("INSERT INTO student (user_id, name, section) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $name, $section);

    if ($stmt->execute()) {
      header("Location: dashboard.php");
      exit();
    } else {
      echo "Error: " . $stmt->error;
    }
  } else {
    echo "Please fill out all fields.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Student</title>
  <link rel="stylesheet" href="add.css">
</head>
<body>
  <div class="container">
    <h2>Add Student</h2>
    <form action="add.php" method="POST">
      <input type="text" name="name" placeholder="Student Name" required><br>
      <input type="text" name="section" placeholder="Course & Section" required><br>
      <button type="submit" name="save">Add Student</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
  </div>
</body>
</html>
