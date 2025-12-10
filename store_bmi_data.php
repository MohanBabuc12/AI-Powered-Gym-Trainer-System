<?php
session_start();
require 'db_connect.php';

// Debugging: Check if session is working
if (!isset($_SESSION['user_id'])) {
    die("Error: User is not logged in. Session not found.");
}

// Retrieve user_id from session
$user_id = $_SESSION['user_id']; 

// Debugging: Check if POST data is received
if (!isset($_POST['weight']) || !isset($_POST['height']) || !isset($_POST['bmi']) || !isset($_POST['body_fat_percentage'])) {
    die("Error: Missing POST data.");
}

// Get the BMI data sent via POST
$weight = $_POST['weight'];
$height = $_POST['height'];
$bmi = $_POST['bmi'];
$body_fat_percentage = $_POST['body_fat_percentage'];

// Debugging: Print received values
echo "Received Data - User ID: $user_id, Weight: $weight, Height: $height, BMI: $bmi, Body Fat: $body_fat_percentage";

// Insert the data into the progresstracking table
$sql = "INSERT INTO progresstracking (user_id, body_weight, bmi, body_fat_percentage) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iddd", $user_id, $weight, $bmi, $body_fat_percentage);

// Execute the statement and check for errors
if ($stmt->execute()) {
    echo "Success: BMI data stored successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
