<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require 'db_connect.php';

// Handle new exercise addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['exercise_name'])) {
    $exercise_name = $conn->real_escape_string($_POST['exercise_name']);
    $insert_sql = "INSERT INTO Exercises (name) VALUES (?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("s", $exercise_name);
    $stmt->execute();
    header("Location: manage_exercises.php?success=Exercise added successfully");
    exit();
}

// Handle exercise deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_sql = "DELETE FROM Exercises WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: manage_exercises.php?success=Exercise deleted successfully");
    exit();
}

// Fetch exercises
$sql = "SELECT * FROM Exercises";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Exercises</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1f2937;
            color: #d1d5db;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #2d3748;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }
        .btn-primary {
            background-color: #34a853;
            border: none;
        }
        .btn-primary:hover {
            background-color: #2c9c46;
        }
        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center">Manage Exercises</h1>

    <?php if (isset($_GET['success'])) : ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">New Exercise Name:</label>
            <input type="text" class="form-control" name="exercise_name" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Add Exercise</button>
    </form>

    <h2 class="text-center mt-4">Existing Exercises</h2>

    <?php if ($result->num_rows > 0): ?>
        <ul class="list-group">
            <?php while($exercise = $result->fetch_assoc()): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo htmlspecialchars($exercise['name']); ?>
                    <a href="manage_exercises.php?delete_id=<?php echo $exercise['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No exercises found.</p>
    <?php endif; ?>

    <div class="text-center mt-3">
        <a href="admin.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</div>

</body>
</html>
