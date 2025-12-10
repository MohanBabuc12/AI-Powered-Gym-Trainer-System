<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require 'db_connect.php';

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$user_id = $_GET['id'];

$delete_user = "DELETE FROM Users WHERE user_id = ?";
$stmt = $conn->prepare($delete_user);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    header("Location: manage_users.php?success=User deleted successfully");
    exit();
} else {
    die("Error deleting user.");
}

$conn->close();
?>
