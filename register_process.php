<?php
session_start();
require 'config.php';

if (isset($_POST['register'])) {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  $check = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $check->bind_param("s", $username);
  $check->execute();
  $result = $check->get_result();

  if ($result->num_rows > 0) {
    $_SESSION['error'] = "Username already taken!";
    header("Location: register.php");
    exit();
  }

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
  $stmt->bind_param("ss", $username, $hashed_password);

  if ($stmt->execute()) {
    $_SESSION['message'] = "Registration successful! You can now login.";
    header("Location: register.php");
  } else {
    $_SESSION['error'] = "Something went wrong. Please try again.";
    header("Location: register.php");
  }
}
?>
