<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
// Check user session
$user_id = $_SESSION['user_id']; // For testing, default to user 1

// Progress Data
$progressQuery = $conn->query("SELECT created_at, body_weight, bmi, body_fat_percentage, lifted_weights FROM progresstracking WHERE user_id = $user_id ORDER BY created_at ASC");
$progressData = [];
while ($row = $progressQuery->fetch_assoc()) {
    $progressData[] = $row;
}

// Food Data
$foodQuery = $conn->query("SELECT date_logged, SUM(calories) AS total_cal FROM foodcomposition WHERE user_id = $user_id GROUP BY date_logged ORDER BY date_logged ASC");
$foodData = [];
while ($row = $foodQuery->fetch_assoc()) {
    $foodData[] = $row;
}

// Workouts
$workoutQuery = $conn->query("SELECT * FROM workoutlogs WHERE user_id = $user_id ORDER BY log_date DESC LIMIT 5");

// Meals
$mealQuery = $conn->query("SELECT * FROM foodcomposition WHERE user_id = $user_id ORDER BY date_logged DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Fitness Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background-color: #1e293b;
      color: #d1d5db;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }

    h1 {
      text-align: center;
      color: #34a853;
      margin-bottom: 30px;
    }

    .dashboard {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 30px;
      margin-bottom: 40px;
    }

    .chart-container, .table-container {
      background: #2d3748;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 8px 12px;
      border-bottom: 1px solid #4a5568;
    }

    th {
      background-color: #1f2937;
      color: #34a853;
    }

    @media(max-width: 768px) {
      .dashboard {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

<h1>Welcome to Your Fitness Dashboard</h1>

<div class="dashboard">
  <!-- Progress Chart -->
  <div class="chart-container">
    <h2>📈 Progress Over Time</h2>
    <canvas id="progressChart"></canvas>
  </div>

  <!-- Calories Chart -->
  <div class="chart-container">
    <h2>🍽️ Calories Intake</h2>
    <canvas id="calorieChart"></canvas>
  </div>
</div>

<div class="dashboard">
  <!-- Recent Workouts -->
  <div class="table-container">
    <h2>🏋️ Recent Workouts</h2>
    <table>
      <tr>
        <th>Date</th>
        <th>Exercise</th>
        <th>Reps</th>
        <th>Weights</th>
      </tr>
      <?php while ($row = $workoutQuery->fetch_assoc()): ?>
      <tr>
        <td><?= $row['log_date'] ?></td>
        <td><?= $row['exercise_name'] ?></td>
        <td><?= $row['repetitions'] ?></td>
        <td><?= $row['weights_lifted'] ?></td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>

  <!-- Recent Meals -->
  <div class="table-container">
    <h2>🍎 Recent Meals</h2>
    <table>
      <tr>
        <th>Date</th>
        <th>Food</th>
        <th>Calories</th>
        <th>Proteins</th>
      </tr>
      <?php while ($row = $mealQuery->fetch_assoc()): ?>
      <tr>
        <td><?= $row['date_logged'] ?></td>
        <td><?= $row['food_name'] ?></td>
        <td><?= $row['calories'] ?></td>
        <td><?= $row['proteins'] ?></td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
</div>


<script>
const progressCtx = document.getElementById('progressChart').getContext('2d');
const calorieCtx = document.getElementById('calorieChart').getContext('2d');

// Progress Data
const progressLabels = <?= json_encode(array_column($progressData, 'created_at')) ?>;
const bodyWeight = <?= json_encode(array_column($progressData, 'body_weight')) ?>;
const bmi = <?= json_encode(array_column($progressData, 'bmi')) ?>;
const fat = <?= json_encode(array_column($progressData, 'body_fat_percentage')) ?>;

new Chart(progressCtx, {
  type: 'line',
  data: {
    labels: progressLabels,
    datasets: [
      {
        label: 'Weight (kg)',
        data: bodyWeight,
        borderColor: '#34a853',
        tension: 0.4
      },
      {
        label: 'BMI',
        data: bmi,
        borderColor: '#3b82f6',
        tension: 0.4
      },
      {
        label: 'Body Fat (%)',
        data: fat,
        borderColor: '#ef4444',
        tension: 0.4
      }
    ]
  },
  options: {
    responsive: true,
    plugins: { legend: { labels: { color: '#fff' } } },
    scales: {
      x: { ticks: { color: '#9ca3af' } },
      y: { ticks: { color: '#9ca3af' } }
    }
  }
});

// Calorie Chart
const calLabels = <?= json_encode(array_column($foodData, 'date_logged')) ?>;
const calories = <?= json_encode(array_column($foodData, 'total_cal')) ?>;

new Chart(calorieCtx, {
  type: 'bar',
  data: {
    labels: calLabels,
    datasets: [{
      label: 'Calories',
      data: calories,
      backgroundColor: '#34a853'
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { labels: { color: '#fff' } } },
    scales: {
      x: { ticks: { color: '#9ca3af' } },
      y: { ticks: { color: '#9ca3af' } }
    }
  }
});
</script>
<a href="HOME.html" class="btn-action" 
     style="
       background-color: #16a085; 
       color: #333; 
       box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
       padding: 12px 30px; 
       border-radius: 12px; 
       font-weight: bold; 
       text-decoration: none; 
       display: inline-block;
       width: 120px;
       text-align: center;
       transition: background-color 0.3s ease;
     ">
    Home
  </a>
</body>
</html>
