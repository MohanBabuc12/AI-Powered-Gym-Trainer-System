<?php
// store_progress.php

session_start();

// Include database connection
require 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit();
}

$data = json_decode($_POST['data'], true);

// Get data from the client-side
$user_id = $_SESSION['user_id']; // Logged in user ID
$body_weight = $data['body_weight'];
$bmi = $data['bmi'];
$body_fat_percentage = $data['body_fat_percentage'];

// Insert the data into the database
$sql = "INSERT INTO progresstracking (user_id, body_weight, bmi, body_fat_percentage) 
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iddd", $user_id, $body_weight, $bmi, $body_fat_percentage);

if ($stmt->execute()) {
    echo "Progress data saved successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
