<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Database connection
$host = 'localhost'; // Replace with your DB host
$dbname = 'Fitnessgym'; // Replace with your DB name
$username = 'root'; // Replace with your DB username
$password = ''; // Replace with your DB password

$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plan_name = $_POST['plan_name'];
    $plan_details = $_POST['plan_details'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $user_id = $_SESSION['user_id']; // Get the logged-in user ID

    // Prepare SQL query to insert data
    $sql = "INSERT INTO FitnessPlans (plan_name, plan_details, start_date, end_date, user_id) 
            VALUES (:plan_name, :plan_details, :start_date, :end_date, :user_id)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':plan_name', $plan_name);
    $stmt->bindParam(':plan_details', $plan_details);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->bindParam(':user_id', $user_id);

    // Execute the query
    if ($stmt->execute()) {
        header('Location: HOME.html');
        exit();
    } else {
        echo 'Error saving plan. Please try again.';
    }
}
?>
