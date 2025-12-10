<?php
// Start the session
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'Fitnessgym'); // Adjust the credentials if needed

// Check for database connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the username and password from the POST request
$username = $_POST['username'];
$password = $_POST['password']; // Plain text password from form

// SQL query to fetch user by username and password
$sql = "SELECT * FROM Users WHERE name = '$username' AND password = '$password'";

// Execute the query
$result = $conn->query($sql);

// Check if a user with the provided username and password exists
if ($result->num_rows > 0) {
    // Start the session for the authenticated user
    $_SESSION['user'] = $username; // You can store other user info if necessary

    // Redirect to HOME.html
    header("Location: HOME.html");
    exit(); // Make sure to stop the script execution after redirection
} else {
    // If login is not successful, alert the user and redirect back to login
    echo "<script>alert('Invalid username or password'); window.location.href = 'login.html';</script>";
}

// Close the database connection
$conn->close();
?>
