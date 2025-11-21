<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
session_start();
require 'config.php';

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      $_SESSION['user'] = $user['username'];
      $_SESSION['user_id'] = $user['id'];
      header("Location: dashboard.php");
      exit();
    } else {
      $_SESSION['error'] = "Incorrect password.";
      header("Location: login.php");
      exit();
    }
  } else {
    $_SESSION['error'] = "User not found.";
    header("Location: login.php");
    exit();
  }
}
?>

</body>
</html>