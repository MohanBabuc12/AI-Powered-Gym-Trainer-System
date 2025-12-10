<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'db_connect.php'; // Ensure this file correctly connects to the database

    // Get user ID from session
    $user_id = $_SESSION['user_id'];

    // Validate and sanitize inputs
    $exercise_name = trim($_POST['exercise_name']);
    $weights_lifted = filter_var($_POST['weights_lifted'], FILTER_VALIDATE_FLOAT);
    $repetitions = filter_var($_POST['repetitions'], FILTER_VALIDATE_INT);
    $log_date = trim($_POST['log_date']);

    // Check for empty values
    if (empty($exercise_name) || $weights_lifted === false || $repetitions === false || empty($log_date)) {
        $_SESSION['error_message'] = "Invalid input! Please fill all fields correctly.";
        header('Location: workoutlogs.php');
        exit();
    }

    // Use prepared statements to prevent SQL injection
    $sql = "INSERT INTO WorkoutLogs (user_id, exercise_name, weights_lifted, repetitions, log_date) 
            VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("issis", $user_id, $exercise_name, $weights_lifted, $repetitions, $log_date);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Workout logged successfully!";
        } else {
            $_SESSION['error_message'] = "Database error: " . $conn->error;
        }

        $stmt->close();
    } else {
        $_SESSION['error_message'] = "Error preparing statement: " . $conn->error;
    }

    $conn->close();
    header('Location: workout_logs.php');
    exit();
}
?>
