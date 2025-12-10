<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #d1d5db;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 40px;
            background-color: #2d3748;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        h1 {
            color: #34a853;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .card {
            background-color: #1c2833;
            color: #d1d5db;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.3);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin-bottom: 30px;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
        }

        .card h2 {
            font-size: 1.8rem;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .card p {
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: #34a853;
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            background-color: #2c9c46;
            transform: scale(1.05);
        }

        .logout {
            margin-top: 30px;
            font-size: 1.1rem;
            color: #f87171;
        }

        .logout a {
            color: #f87171;
            font-weight: bold;
            text-decoration: none;
        }

        .logout a:hover {
            color: #dc2626;
            text-decoration: underline;
        }

        .footer {
            font-size: 0.9rem;
            color: #b1b1b1;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Admin Dashboard</h1>

    <!-- Manage Users Card -->
    <div class="card">
        <h2>Manage Users</h2>
        <p>View, add, edit, or remove users from the platform.</p>
        <a href="manage_users.php" class="btn">Go to Users</a>
    </div>

    <!-- Progress Reports Card -->
    <div class="card">
        <h2>Progress Reports</h2>
        <p>Track and analyze user fitness progress and activities.</p>
        <a href="progress_reports.php" class="btn">View Reports</a>
    </div>

    <!-- Manage Exercises Card -->
    <div class="card">
        <h2>Manage Exercises</h2>
        <p>Add or delete exercises to keep the workout library updated.</p>
        <a href="manage_exercises.php" class="btn">Go to Exercises</a>
    </div>

    <!-- Logout Link -->
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 Fitness Platform. All rights reserved.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
