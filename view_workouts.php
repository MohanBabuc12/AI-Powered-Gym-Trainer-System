<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Connect to DB
$conn = new mysqli('localhost', 'root', '', 'fitnessgym');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Filters initialization
$filters = [];
$params = [];
$types = '';

// Process filters from GET
if (!empty($_GET['exercise_name'])) {
    $filters[] = "exercise_name LIKE ?";
    $params[] = '%' . $_GET['exercise_name'] . '%';
    $types .= 's';
}

if (!empty($_GET['start_date'])) {
    $filters[] = "log_date >= ?";
    $params[] = $_GET['start_date'];
    $types .= 's';
}

if (!empty($_GET['end_date'])) {
    $filters[] = "log_date <= ?";
    $params[] = $_GET['end_date'];
    $types .= 's';
}

// Build WHERE clause
$where_sql = '';
if ($filters) {
    $where_sql = ' AND ' . implode(' AND ', $filters);
}

// Prepare SQL query
$sql = "SELECT * FROM workoutlogs WHERE user_id = ?" . $where_sql . " ORDER BY log_date DESC";
$stmt = $conn->prepare($sql);

// Prepare bind_param arguments dynamically
$param_types = 'i';
$param_values = [$user_id];
if ($types !== '') {
    $param_types .= $types;
    foreach ($params as $p) {
        $param_values[] = $p;
    }
}

// Create references for bind_param (needed by call_user_func_array)
$bind_names = [];
$bind_names[] = &$param_types;
for ($i = 0; $i < count($param_values); $i++) {
    $bind_names[] = &$param_values[$i];
}

// Bind parameters and execute
call_user_func_array([$stmt, 'bind_param'], $bind_names);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Your Workout Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <style>
        body {
            background-color: #1f2937;
            color: #d1d5db;
            font-family: 'Arial', sans-serif;
            padding: 40px;
        }
        h1 {
            text-align: center;
            color: #34a853;
            margin-bottom: 30px;
            font-weight: 700;
        }
        table {
            background-color: #2d3748;
        }
        th, td {
            color: #f1f5f9;
        }
        .table-secondary {
            background-color: #4a5568 !important;
        }
        .btn-home, .btn-download {
            display: block;
            width: 200px;
            margin: 20px auto 0;
            background-color: #34a853;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-size: 1rem;
            text-align: center;
            transition: 0.3s;
            text-decoration: none;
            cursor: pointer;
            user-select: none;
        }
        .btn-home:hover, .btn-download:hover {
            background-color: #2c9c46;
            transform: scale(1.03);
            color: white;
            text-decoration: none;
        }
        .filter-form {
            max-width: 700px;
            margin: 0 auto 40px;
            background-color: #2d3748;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }
        .filter-form label {
            color: #a0aec0;
            font-weight: 600;
        }
        .filter-form .btn-filter {
            background-color: #34a853;
            border: none;
        }
        .filter-form .btn-filter:hover {
            background-color: #2c9c46;
        }
    </style>
</head>
<body>

<h1>Your Workout Logs</h1>

<!-- Filter Form -->
<form method="GET" class="filter-form row g-3 align-items-end">
    <div class="col-md-4">
        <label for="exercise_name" class="form-label">Filter by Exercise</label>
        <input type="text" id="exercise_name" name="exercise_name" class="form-control" 
            value="<?= isset($_GET['exercise_name']) ? htmlspecialchars($_GET['exercise_name']) : '' ?>" 
            placeholder="e.g., Squat, Pushup" />
    </div>
    <div class="col-md-3">
        <label for="start_date" class="form-label">Start Date</label>
        <input type="date" id="start_date" name="start_date" class="form-control"
            value="<?= isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : '' ?>" />
    </div>
    <div class="col-md-3">
        <label for="end_date" class="form-label">End Date</label>
        <input type="date" id="end_date" name="end_date" class="form-control"
            value="<?= isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : '' ?>" />
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-filter w-100">Filter</button>
    </div>
</form>


<div class="table-responsive">
    <table class="table table-bordered table-striped text-center align-middle" id="workoutTable">
        <thead class="table-dark">
            <tr>
                <th>Date</th>
                <th>Exercise</th>
                <th>Weight Lifted</th>
                <th>Repetitions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0):
            $logs_by_date = [];

            // Group rows by date
            while ($row = $result->fetch_assoc()) {
                $logs_by_date[$row['log_date']][] = $row;
            }

            foreach ($logs_by_date as $date => $entries):
        ?>
            <tr class="table-secondary">
                <td class="fw-bold text-start" colspan="4"><?= htmlspecialchars($date) ?></td>
            </tr>
            <?php foreach ($entries as $log): ?>
            <tr>
                <td></td> <!-- empty cell under Date -->
                <td><?= htmlspecialchars($log['exercise_name']) ?></td>
                <td><?= htmlspecialchars($log['weights_lifted']) ?> kg</td>
                <td><?= htmlspecialchars($log['repetitions']) ?></td>
            </tr>
            <?php endforeach; ?>
        <?php
            endforeach;
        else:
        ?>
            <tr>
                <td colspan="4">No workout logs found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<!-- Download PDF Button -->
<button id="downloadPdfBtn" class="btn-download" aria-label="Download workout logs as PDF">
    Download Workout Logs PDF
</button>

<a href="home.html" class="btn-home">Back to Home</a>

<script>
document.getElementById('downloadPdfBtn').addEventListener('click', () => {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const table = document.getElementById('workoutTable');
    let y = 15; // vertical start position on PDF
    const lineHeight = 10;
    const pageHeight = 295;
    const marginRight = 200;

    // Title
    doc.setFontSize(18);
    doc.setTextColor(40, 40, 40);
    doc.text("🗓️ Your Workout Logs", 10, y);
    y += 15;

    // Table Header
    doc.setFontSize(13);
    doc.setFont("helvetica", "bold");
    doc.text("Date", 10, y);
    doc.text("Exercise", 55, y);
    doc.text("Weight (kg)", 130, y);
    doc.text("Repetitions", 170, y);
    y += 7;
    doc.setDrawColor(0);
    doc.setLineWidth(0.5);
    doc.line(10, y, marginRight, y); // underline
    y += 5;

    doc.setFont("helvetica", "normal");
    doc.setTextColor(20, 20, 20);

    // Iterate rows - handle date group headers and workout entries
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');

        if (row.classList.contains('table-secondary')) {
            // Date group header row
            if (y > pageHeight) {
                doc.addPage();
                y = 20;
            }
            doc.setFont("helvetica", "bold");
            doc.setTextColor(52, 168, 83); // green-ish
            doc.text(cells[0].textContent.trim(), 10, y);
            y += lineHeight;
            doc.setFont("helvetica", "normal");
            doc.setTextColor(20, 20, 20);
        } else {
            // Regular data row
            if (y > pageHeight) {
                doc.addPage();
                y = 20;
            }
            // Date column empty
            doc.text("-", 10, y); // or leave blank
            doc.text(cells[1].textContent.trim(), 55, y);
            doc.text(cells[2].textContent.trim(), 130, y);
            doc.text(cells[3].textContent.trim(), 170, y);
            y += lineHeight;
        }
    });

    doc.save('workout_logs.pdf');
});
</script>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
