<?php
// db_connect.php
$servername = "localhost";
$username = "root";
$password = "";

// Try multiple possible database names (handles case or rename differences)
$possible_dbs = ["Fitnessgym", "fitnessgym"];
$conn = null;
$dbname = null;
foreach ($possible_dbs as $try_db) {
    $temp = @new mysqli($servername, $username, $password, $try_db);
    if ($temp && !$temp->connect_error) {
        $conn = $temp;
        $dbname = $try_db;
        break;
    }
    if ($temp) {
        $temp->close();
    }
}

// Final check
if (!($conn instanceof mysqli) || $conn->connect_error) {
    $err = $conn instanceof mysqli ? $conn->connect_error : 'Unable to connect';
    die("Connection failed: " . $err);
}
?>
