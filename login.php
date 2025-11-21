<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style.css">
  <title>Login</title>
</head>
<script>
function togglePassword() {
  const password = document.getElementById("password");
  password.type = document.getElementById("showPassword").checked ? "text" : "password";
}
</script>

<body>
<div class="container">
  <h2>Login</h2>
  <form action="login_process.php" method="POST">
    <label>Username:</label>
    <input type="text" name="username" required><br><br>

    <label for="password">Password:</label>
<input type="password" name="password" id="password" required>
<label class="show-password">
  <input type="checkbox" id="showPassword" onclick="togglePassword()">
  Show password
</label>
<br>
    <button type="submit" name="login">Login</button>
  </form>

  <?php
  session_start();
  if (isset($_SESSION['error'])) {
    echo "<p style='color:red;'>".$_SESSION['error']."</p>";
    unset($_SESSION['error']);
  }
  ?>
  <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>
