<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require 'db_connect.php';

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$user_id = $_GET['id'];

// Fetch user details
$sql = "SELECT * FROM Users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = $conn->real_escape_string($_POST['name']);
    $new_role = $conn->real_escape_string($_POST['role']);
    $new_weight = $_POST['weight'];
    $new_height = $_POST['height'];
    
    // Update password only if a new one is entered
    if (!empty($_POST['password'])) {
        $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $update_sql = "UPDATE Users SET name = ?, password = ?, role = ?, weight = ?, height = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssssdi", $new_name, $new_password, $new_role, $new_weight, $new_height, $user_id);
    } else {
        $update_sql = "UPDATE Users SET name = ?, role = ?, weight = ?, height = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssdi", $new_name, $new_role, $new_weight, $new_height, $user_id);
    }

    if ($update_stmt->execute()) {
        header("Location: manage_users.php?success=User updated successfully");
        exit();
    } else {
        $error = "Error updating user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center">Edit User</h1>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Name:</label>
            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">New Password (Leave blank to keep current password):</label>
            <input type="password" class="form-control" name="password" placeholder="Enter new password">
        </div>

        <div class="mb-3">
            <label class="form-label">Role:</label>
            <select name="role" class="form-select">
                <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
                <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Weight (kg):</label>
            <input type="number" class="form-control" name="weight" value="<?php echo $user['weight'] ?? ''; ?>" step="0.1">
        </div>

        <div class="mb-3">
            <label class="form-label">Height (cm):</label>
            <input type="number" class="form-control" name="height" value="<?php echo $user['height'] ?? ''; ?>" step="0.1">
        </div>

        <button type="submit" class="btn btn-primary w-100">Update User</button>
    </form>

    <div class="text-center mt-3">
        <a href="manage_users.php" class="btn btn-secondary">Back to Users</a>
    </div>
</div>

</body>
</html>
