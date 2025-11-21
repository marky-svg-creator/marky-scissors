<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM student WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="dash.css">
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar">
    <div class="nav-left">
      <h1>Student Dashboard</h1>
    </div>
    <div class="nav-right">
      <form action="logout.php" method="POST" onsubmit="return confirmLogout()">
        <button type="submit" name="logout" class="logout-btn">Logout</button>
      </form>

      <script>
        function confirmLogout() {
          return confirm("Are you sure you want to logout?");
        }
      </script>
    </div>
  </nav>

  <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?> 👋</h2>

  <div class="container">
    <div class="header-row">
      <h3>Your Students</h3>
      <a href="add.php" class="btn-create">+ Add Student</a>
    </div>

    <table>
      <tr>
        <th>Name</th>
        <th>Course & Section</th>
        <th>Actions</th>
      </tr>

      <?php if ($result->num_rows > 0) { ?>
        <?php while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['section']); ?></td>
            <td class="actions">
              <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
              <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Delete this student?');">Delete</a>
            </td>
          </tr> 
        <?php } ?>
      <?php } else { ?>
        <tr>
          <td colspan="3" style="text-align:center; padding:15px;">No students found.</td>
        </tr>
      <?php } ?>
    </table>
  </div>
</body>
</html>
