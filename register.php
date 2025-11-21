<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="regi.css">
  <title>Register</title>
</head>

<body>
<div class="container">
  <h2>Register New Account</h2>
  <form action="register_process.php" method="POST">
    <label>Username:</label>
    <input type="text" name="username" required><br><br>

    <label for="password">Password:</label>
<input type="password" name="password" id="password" required>
<label class="show-password">
  <input type="checkbox" id="showPassword" onclick="togglePassword()">
  Show password
</label>
<br>
    <button type="submit" name="register">Register</button>
  </form>

  <?php
session_start();

if (isset($_SESSION['message'])) {
  $msg = addslashes($_SESSION['message']);
  echo "
  <script>
    alert('$msg');
    window.location.href = 'login.php';
  </script>
  ";
  unset($_SESSION['message']);
}

if (isset($_SESSION['error'])) {
  $err = addslashes($_SESSION['error']);
  echo "
  <script>
    alert('$err');
    window.location.href = 'register.php';
  </script>
  ";
  unset($_SESSION['error']);
}
?>

  <p>Already have an account? <a href="login.php">Login here</a></p>
  <script>
function togglePassword() {
  const password = document.getElementById("password");
  password.type = document.getElementById("showPassword").checked ? "text" : "password";
}
</script>

</body>
</html>
