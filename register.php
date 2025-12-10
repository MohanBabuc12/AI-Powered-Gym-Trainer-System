<?php
// Use centralized DB connection
require_once 'db_connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user data from the form
    $username = $_POST['username'];
    $password = $_POST['password'];  // Store password as plain text
    $weight = $_POST['weight'];
    $height = $_POST['height'];

    // SQL query to insert the new user data into the Users table
    $sql = "INSERT INTO Users (name, weight, height, password) VALUES ('$username', '$weight', '$height', '$password')";

    // Execute the query and check if the user is added successfully
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Account created successfully!'); window.location.href = 'login.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="signup-container">
        <h1>Create Account</h1>
        <form action="register.php" method="POST">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="weight">Weight:</label>
                <input type="number" id="weight" name="weight" required>
            </div>
            <div class="input-group">
                <label for="height">Height:</label>
                <input type="number" id="height" name="height" required>
            </div>
            <button type="submit">Create Account</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
