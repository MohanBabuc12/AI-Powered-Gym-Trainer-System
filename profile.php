<?php
session_start();
require 'db_connect.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details securely using prepared statements
$sql = "SELECT * FROM Users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Handle profile update securely
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $weight = $_POST['weight'];
    $height = $_POST['height'];

    if ($weight < 20 || $weight > 300 || $height < 100 || $height > 250) {
        $error_message = "Please enter a valid weight (20-300 kg) and height (100-250 cm).";
    } else {
        $update_sql = "UPDATE Users SET weight = ?, height = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ddi", $weight, $height, $user_id);

        if ($update_stmt->execute()) {
            header('Location: profile.php?success=1');
            exit();
        } else {
            $error_message = "Error updating profile: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #1f2937;
            color: #d1d5db;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem;
        }
        .profile-container {
            background: #2d3748;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            max-width: 480px;
            margin: 0 auto;
            padding: 2.5rem 3rem;
            transition: transform 0.3s ease;
        }
        .profile-container:hover {
            transform: translateY(-5px);
        }
        h1 {
            color: #34a853;
            font-weight: 700;
            font-size: 2.25rem;
            margin-bottom: 1.5rem;
            text-align: center;
            letter-spacing: 1.1px;
        }
        .alert {
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 1.25rem;
            padding: 0.85rem 1.25rem;
            text-align: center;
            user-select: none;
        }
        .alert-success {
            background-color: #34a853;
            color: white;
        }
        .alert-danger {
            background-color: #e74c3c;
            color: white;
        }
        label {
            color: #a0aec0;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: inline-block;
        }
        input[type="text"],
        input[type="number"] {
            background-color: #1a202c;
            border: 1.8px solid #4a5568;
            border-radius: 10px;
            color: #d1d5db;
            font-size: 1rem;
            padding: 0.7rem 1rem;
            width: 100%;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            user-select: text;
        }
        input[type="text"]:disabled {
            background-color: #374151;
            color: #94a3b8;
            cursor: not-allowed;
            user-select: none;
        }
        input[type="text"]:focus,
        input[type="number"]:focus {
            outline: none;
            border-color: #34a853;
            box-shadow: 0 0 8px rgba(52, 168, 83, 0.7);
        }
        button[type="submit"] {
            background-color: #34a853;
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            padding: 0.9rem;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.15s ease;
            margin-top: 0.8rem;
            user-select: none;
        }
        button[type="submit"]:hover {
            background-color: #2c9c46;
            transform: scale(1.05);
        }
        .links {
            margin-top: 1.75rem;
            text-align: center;
        }
        .links a {
            color: #34a853;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            margin: 0 0.75rem;
            transition: color 0.25s ease;
            user-select: none;
        }
        .links a:hover,
        .links a:focus {
            color: #2c9c46;
            text-decoration: underline;
        }
        .btn-view-logs {
            margin-top: 1.5rem;
            display: inline-block;
            width: 100%;
            font-size: 1.1rem;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 12px;
            text-align: center;
            background-color: #34a853;
            color: white;
            text-decoration: none;
            user-select: none;
            transition: background-color 0.3s ease;
        }
        .btn-view-logs:hover {
            background-color: #2c9c46;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <main class="profile-container" role="main" aria-label="User profile details and update form">
        <h1>Profile Details</h1>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" role="alert">Profile updated successfully!</div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form method="POST" action="profile.php" novalidate>
            <div class="mb-4">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['name']); ?>" disabled aria-disabled="true" />
            </div>

            <div class="mb-4">
                <label for="weight">Weight (kg)</label>
                <input type="number" id="weight" name="weight" value="<?php echo htmlspecialchars($user['weight']); ?>" min="20" max="300" required aria-required="true" />
            </div>

            <div class="mb-4">
                <label for="height">Height (cm)</label>
                <input type="number" id="height" name="height" value="<?php echo htmlspecialchars($user['height']); ?>" min="100" max="250" required aria-required="true" />
            </div>

            <button type="submit" aria-label="Update Profile">Update Profile</button>
        </form>

        <div class="links">
            <a href="track_progress.php" aria-label="Go to track progress page">Track Progress</a> |
            <a href="home.html" aria-label="Return to home page">Back to Home</a>
        </div>

        <a href="view_workouts.php" class="btn-view-logs" aria-label="View Workout Logs">
            📝 View Workout Logs
        </a>
    </main>

</body>
</html>
