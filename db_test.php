<?php
// db_test.php - quick DB connection + tables check
require_once 'db_connect.php';

echo "<h2>DB connection test</h2>";

if (isset($conn) && $conn instanceof mysqli) {
    echo "<p>Connected to database: <strong>" . htmlspecialchars($dbname) . "</strong></p>";
} else {
    echo "<p>Connection variable not available.</p>";
    exit;
}

$result = $conn->query("SHOW TABLES");
if ($result) {
    echo "<h3>Tables:</h3>";
    echo "<ul>";
    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        echo "<li>" . htmlspecialchars($row[0]) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Failed to list tables: " . htmlspecialchars($conn->error) . "</p>";
}

$conn->close();
?>
