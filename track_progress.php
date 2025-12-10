<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require 'db_connect.php';

$user_id = $_SESSION['user_id'];

// Fetch progress data from the database (without lifted_weights)
$sql = "SELECT progress_id, body_weight, bmi, body_fat_percentage, DATE(created_at) as progress_date 
        FROM progresstracking 
        WHERE user_id = ? 
        ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Progress</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1f2937;
            color: #d1d5db;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            margin-top: 50px;
            background-color: #2d3748;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        h1 {
            color: #34a853;
            text-align: center;
            margin-bottom: 20px;
        }

        .table {
            color: #d1d5db;
        }

        .table th {
            background-color: #2c3e50;
        }

        .table td {
            background-color: whitesmoke;
            border-top: 1px solid #4a5568;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .btn-back {
            margin-top: 20px;
            display: block;
            width: 100%;
            text-align: center;
        }

        .btn-back:hover {
            background-color: #34a853;
            border-color: #34a853;
            color: white;
        }

        @media (max-width: 576px) {
            .table th, .table td {
                font-size: 0.9rem;
            }
            .btn-back {
                margin-top: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Track Progress</h1>
        <?php if ($result->num_rows > 0) : ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Body Weight (kg)</th>
                        <th>BMI</th>
                        <th>Body Fat (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['progress_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['body_weight']); ?></td>
                            <td><?php echo htmlspecialchars($row['bmi']); ?></td>
                            <td><?php echo htmlspecialchars($row['body_fat_percentage']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p class="text-center text-muted">No progress data available yet. Start tracking your progress!</p>
        <?php endif; ?>
        <a href="profile.php" class="btn btn-secondary btn-back">Back to Profile</a>
    </div>
</body>

</html>
