<?php
session_start();
require 'config.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'] ?? null;

if ($id) {
    
    $stmt = $conn->prepare("DELETE FROM student WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Student deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting student. Please try again.";
    }

    $stmt->close();
}

header("Location: dashboard.php");
exit();
?>
