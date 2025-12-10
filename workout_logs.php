<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Success/Error Messages Handling
$success_message = $_SESSION['success_message'] ?? '';
$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['success_message'], $_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1f2937; /* Dark background */
            color: #d1d5db; /* Light text */
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .workout-log-container {
            width: 100%;
            max-width: 500px;
            padding: 30px 40px;
            background-color: #2d3748; /* Card background */
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        h1 {
            text-align: center;
            color: #34a853; /* Accent green */
            font-size: 2rem;
            font-weight: bold;
        }

        .form-label {
            color: #a0aec0; /* Subtle label color */
        }

        .form-control, .form-select {
            background-color: #1a202c;
            color: #d1d5db;
            border: 1px solid #4a5568;
            border-radius: 8px;
            padding: 12px;
        }

        .form-control:focus, .form-select:focus {
            border-color: #34a853;
            box-shadow: 0 0 8px rgba(52, 168, 83, 0.6);
        }

        button {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-success {
            background-color: #34a853;
            color: #fff;
        }

        .btn-success:hover {
            background-color: #2c9c46;
            transform: scale(1.03);
        }

        .btn-danger {
            background-color: #e53e3e;
        }

        .btn-danger:hover {
            background-color: #c53030;
        }

        .btn-secondary {
            background-color: #4a5568;
        }

        .btn-secondary:hover {
            background-color: #374151;
        }
    </style>
</head>
<body>
    <div class="workout-log-container">
        <h1>Log Your Workout</h1>

        <!-- Success/Error Messages -->
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?= $success_message; ?></div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?= $error_message; ?></div>
        <?php endif; ?>

        <form action="save_workout.php" method="POST">
            <!-- Dropdown for Exercise Name -->
            <div class="mb-3">
                <label for="exercise_name" class="form-label">Exercise Name:</label>
                <select class="form-select" id="exercise_name" name="exercise_name" required>
                    <option value="" selected disabled>Select an Exercise</option>
                    <option value="Lateral Rise">Lateral Rise</option>
                    <option value="Alternative Dumbbell Curls">Alternative Dumbbell Curls</option>
                    <option value="Barbell Row">Barbell Row</option>
                    <option value="Push Up">Push Up</option>
                    <option value="Squats">Squats</option>
                    <option value="Shoulder Press">Shoulder Press</option>
                    <option value="Tricep Dips">Tricep Dips</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="weights_lifted" class="form-label">Weights Lifted (kg):</label>
                <input type="number" step="0.1" id="weights_lifted" name="weights_lifted" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="repetitions" class="form-label">Repetitions:</label>
                <input type="number" id="repetitions" name="repetitions" class="form-control" required>
            </div>

            <!-- Automatic Date -->
            <div class="mb-3">
                <label for="log_date" class="form-label">Date:</label>
                <input type="date" id="log_date" name="log_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Save Workout</button>
            <button class="btn btn-danger w-100 mt-3" onclick="history.back()">Cancel</button>
            <button class="btn btn-secondary w-100 mt-3" onclick="window.location.href='HOME.html'">Back to Home</button>
        </form>
    </div>
</body>
</html>
