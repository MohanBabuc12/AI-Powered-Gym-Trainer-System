<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require 'db_connect.php'; // Include your database connection

// Fetch the progress data from the database
$sql = "SELECT user_id, body_weight, lifted_weights, bmi, body_fat_percentage, created_at FROM progresstracking";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1f2937;
            color: #d1d5db;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background-color: #2d3748;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        .table {
            background-color: #1a202c;
            color: #d1d5db;
        }

        .btn {
            background-color: #34a853;
            color: white;
        }

        .btn:hover {
            background-color: #2c9c46;
        }

        .logout {
            text-align: center;
            margin-top: 20px;
        }

        .logout a {
            color: #f87171;
            font-weight: bold;
            text-decoration: none;
        }

        .logout a:hover {
            color: #dc2626;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center">Progress Reports</h1>
    
    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Body Weight</th>
                    <th>Lifting Weights</th>
                    <th>BMI</th>
                    <th>Body Fat Percentage</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['body_weight']; ?> kg</td>
                        <td><?php echo $row['lifted_weights']; ?> kg</td>
                        <td><?php echo $row['bmi']; ?></td>
                        <td><?php echo $row['body_fat_percentage']; ?>%</td>
                        <td><?php echo $row['created_at']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No progress reports found.</p>
    <?php endif; ?>

    <div class="logout">
        <a href="admin.php">Back to Dashboard</a> | <a href="logout.php">Logout</a>
    </div>
</div>

</body>
</html>

<?php
$conn->close(); // Close connection
?>
