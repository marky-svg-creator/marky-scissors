<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: dashboard.php");
    exit();
}

// Fetch existing record
$stmt = $conn->prepare("SELECT * FROM student WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    echo "Record not found or access denied.";
    exit();
}

// Update record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $section = trim($_POST['section']);

    if (!empty($name) && !empty($section)) {
        $update = $conn->prepare("UPDATE student SET name = ?, section = ? WHERE id = ? AND user_id = ?");
        $update->bind_param("ssii", $name, $section, $id, $user_id);

        if ($update->execute()) {
            $_SESSION['message'] = "Student updated successfully!";
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error updating record.";
        }
    } else {
        echo "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Student</title>
  <link rel="stylesheet" href="edit.css">
</head>
<body>
  <div class="container">
    <h2>Edit Student</h2>
    <form method="POST">
      <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required><br>
      <input type="text" name="section" value="<?php echo htmlspecialchars($student['section']); ?>" required><br>
      <button type="submit" name="update" onclick="return confirmSave()">Save Changes</button>
      <script>
function confirmSave() {
  return confirm("Are you sure you want to save these changes?");
}
</script>

      <a href="dashboard.php" class="btn-cancel">Cancel</a>
    </form>
  </div>
</body>
</html>
