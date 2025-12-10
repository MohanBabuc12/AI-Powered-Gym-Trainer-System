<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dynamic Workout Plan Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #1f2937;
            color: #d1d5db;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 850px;
            margin-top: 50px;
            padding: 40px;
            background-color: #2d3748;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        h1 {
            color: #34a853;
            font-size: 2.2rem;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-label {
            color: #a0aec0;
            font-weight: 500;
        }

        .form-control,
        .form-select {
            background-color: #1a202c;
            color: #d1d5db;
            border: 1px solid #4a5568;
            border-radius: 8px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #34a853;
            box-shadow: 0 0 8px rgba(52, 168, 83, 0.6);
        }

        .btn-submit {
            background-color: #16a085;
            color: white;
            font-weight: bold;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            margin-top: 15px;
        }

        .btn-submit:hover {
            background-color: #1abc9c;
        }

        .card {
            background-color: #34495e;
            color: #ecf0f1;
            margin-top: 30px;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4);
        }

        .card-header {
            background-color: #1abc9c;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .exercise-list li {
            margin-bottom: 8px;
        }

        .btn-actions {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-action {
            background-color: #16a085;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-action:hover {
            background-color: #1abc9c;
        }

        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            background-color: #2d3748;
        }

        th,
        td {
            padding: 15px 12px;
            text-align: left;
            border-bottom: 1px solid #4a5568;
            font-weight: 500;
        }

        th {
            background-color: #16a085;
            color: #fff;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Dynamic Workout Plan Generator</h1>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" min="10" max="100" id="age" name="age" placeholder="Enter your age" required
                    class="form-control" value="<?php echo isset($_POST['age']) ? htmlspecialchars($_POST['age']) : '' ?>" />
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select id="gender" name="gender" required class="form-select">
                    <option value="" disabled <?php if (!isset($_POST['gender'])) echo 'selected'; ?>>Select Gender
                    </option>
                    <option value="male" <?php if (isset($_POST['gender']) && $_POST['gender'] == 'male') echo 'selected'; ?>>
                        Male</option>
                    <option value="female"
                        <?php if (isset($_POST['gender']) && $_POST['gender'] == 'female') echo 'selected'; ?>>Female
                    </option>
                    <option value="other" <?php if (isset($_POST['gender']) && $_POST['gender'] == 'other') echo 'selected'; ?>>
                        Other</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="height" class="form-label">Height (cm)</label>
                <input type="number" min="50" max="300" id="height" name="height" placeholder="Enter your height in cm"
                    required class="form-control"
                    value="<?php echo isset($_POST['height']) ? htmlspecialchars($_POST['height']) : '' ?>" />
            </div>

            <div class="mb-3">
                <label for="weight" class="form-label">Weight (kg)</label>
                <input type="number" min="20" max="300" id="weight" name="weight" placeholder="Enter your weight in kg"
                    required class="form-control"
                    value="<?php echo isset($_POST['weight']) ? htmlspecialchars($_POST['weight']) : '' ?>" />
            </div>

            <div class="mb-3">
                <label for="activity" class="form-label">Activity Level</label>
                <select id="activity" name="activity" required class="form-select">
                    <option value="" disabled <?php if (!isset($_POST['activity'])) echo 'selected'; ?>>Select Activity
                        Level
                    </option>
                    <option value="sedentary"
                        <?php if (isset($_POST['activity']) && $_POST['activity'] == 'sedentary') echo 'selected'; ?>>Sedentary
                        (little or no exercise)</option>
                    <option value="active"
                        <?php if (isset($_POST['activity']) && $_POST['activity'] == 'active') echo 'selected'; ?>>Active
                        (moderate exercise 3-5 days/week)</option>
                    <option value="very_active"
                        <?php if (isset($_POST['activity']) && $_POST['activity'] == 'very_active') echo 'selected'; ?>>Very
                        Active (hard exercise 6-7 days/week)</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="goal" class="form-label">Fitness Goal</label>
                <select id="goal" name="goal" required class="form-select">
                    <option value="" disabled <?php if (!isset($_POST['goal'])) echo 'selected'; ?>>Select Goal</option>
                    <option value="weight_loss"
                        <?php if (isset($_POST['goal']) && $_POST['goal'] == 'weight_loss') echo 'selected'; ?>>Weight Loss
                    </option>
                    <option value="muscle_gain"
                        <?php if (isset($_POST['goal']) && $_POST['goal'] == 'muscle_gain') echo 'selected'; ?>>Muscle Gain
                    </option>
                    <option value="maintain"
                        <?php if (isset($_POST['goal']) && $_POST['goal'] == 'maintain') echo 'selected'; ?>>Maintain Weight
                    </option>
                </select>
            </div>

            <button type="submit" class="btn-submit">Generate Weekly Workout Plan</button>
        </form>

        <?php
        function generateWorkoutPlan($activity, $goal)
        {
            $plan = [];

            if ($goal == 'weight_loss') {
                $plan =[
                    'Monday' => 'Cardio: Running or Cycling - 30 mins steady pace',
                    'Tuesday' => 'Strength Training: Squats (4 sets x 12 reps), Push-ups (4x10), Lunges (3x12 each leg), Plank (3x30 sec)',
                    'Wednesday' => 'HIIT Cardio: 5 rounds of Jumping Jacks (30 sec), Burpees (10 reps), High Knees (30 sec), Rest (30 sec)',
                    'Thursday' => 'Bodyweight Strength: Push-ups (4x12), Walking Lunges (3x20 steps), Tricep Dips (3x15), Wall Sit (3x40 sec), Leg Raises (3x20)',
                    'Friday' => 'Cardio & Mobility: Swimming or Brisk Walking - 30-40 mins, Dynamic Stretching - 10 mins',
                    'Saturday' => 'Strength Training with Weights: Deadlifts (4x10), Overhead Press (3x12), Resistance Band Rows (4x15), Bicep Curls (3x12)',
                    'Sunday' => 'Rest & Recovery: Light Stretching or Foam Rolling - 15-20 mins, Meditation or Breathing Exercises - 10-15 mins'
                ];     
            } 
            
            elseif ($goal == 'muscle_gain') {
                $plan = [
                    'Monday' => 'Upper Body Strength: Bench Press (4x8-10), Pull-Ups or Lat Pulldown (4x8-12), Dumbbell Shoulder Press (4x10), Barbell Rows (3x8-10), Bicep Curls (3x12)',
                    'Tuesday' => 'Lower Body Strength: Squats (4x8-12), Romanian Deadlifts (4x10), Leg Press (3x10-12), Walking Lunges (3x20 steps), Calf Raises (4x15-20)',
                    'Wednesday' => 'Light Cardio: Jogging or Cycling - 20 mins steady pace, Stretching and Mobility - 10 mins',
                    'Thursday' => 'Push Focus Strength: Incline Dumbbell Press (4x8-10), Overhead Barbell Press (4x8-10), Triceps Dips or Skull Crushers (3x12), Lateral Raises (3x15), Push-ups (3x15-20)',
                    'Friday' => 'Pull Focus Strength: Deadlifts (4x6-8), Chin-Ups (4x8-10), Barbell or Dumbbell Rows (4x10), Face Pulls (3x15), Hammer Curls (3x12)',
                    'Saturday' => 'Active Recovery Cardio: Swimming, brisk walking, or cycling - 30-40 mins',
                ];
            } else { // maintain
                $plan = [
                    'Monday' => 'Mixed Cardio & Strength (Moderate)',
                    'Tuesday' => 'Strength Training (Full body)',
                    'Wednesday' => 'Cardio (Moderate intensity)',
                    'Thursday' => 'Strength Training (Focus on weak areas)',
                    'Friday' => 'Cardio (Light)',
                    'Saturday' => 'Strength Training (Bodyweight)',
                    'Sunday' => 'Rest & Recovery',
                ];
            }

            if ($activity == 'sedentary') {
                foreach ($plan as $day => $activityDesc) {
                    if (stripos($activityDesc, 'Strength') !== false) {
                        $plan[$day] = 'Light Strength Training (Bodyweight, low reps)';
                    } elseif (stripos($activityDesc, 'Cardio') !== false) {
                        $plan[$day] = 'Light Cardio (Walking - 15 mins)';
                    }
                }
            }

            return $plan;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $activity = $_POST['activity'];
            $goal = $_POST['goal'];

            $weeklyPlan = generateWorkoutPlan($activity, $goal);

            echo '<div class="card">';
            echo '<div class="card-header">Your 7-Day Workout Schedule</div>';
            echo '<div class="card-body">';
            echo '<table>';
            echo '<thead><tr><th>Day</th><th>Workout</th></tr></thead><tbody>';

            foreach ($weeklyPlan as $day => $workout) {
                echo '<tr><td><strong>' . htmlspecialchars($day) . '</strong></td><td>' . htmlspecialchars($workout) . '</td></tr>';
            }

            echo '</tbody></table>';

            echo '<div class="btn-actions">';
            echo '<button onclick="printPlan()" class="btn-action">Print Plan</button>';
            echo '<button onclick="downloadPDF()" class="btn-action">Download PDF</button>';
            echo '</div>';

            echo '</div></div>';
        }
        ?>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        function printPlan() {
            const content = document.querySelector('.card-body').innerHTML;
            const originalContent = document.body.innerHTML;
            document.body.innerHTML = content;
            window.print();
            document.body.innerHTML = originalContent;
            location.reload();
        }

        async function downloadPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const table = document.querySelector('table');
            let text = '7-Day Workout Schedule\n\n';

            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const day = row.cells[0].innerText;
                const workout = row.cells[1].innerText;
                text += `${day}: ${workout}\n\n`;
            });

            doc.setFontSize(14);
            doc.text(text, 10, 10);
            doc.save('Workout_Schedule.pdf');
        }
    </script>
    <div style="text-align: center; margin-top: 20px;">
  <a href="home.html" style="text-decoration: none;">
    <button style="
      background-color: #16a085;
      color: #fff;
      padding: 10px 25px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    " onmouseover="this.style.backgroundColor='#555'" onmouseout="this.style.backgroundColor='#333'">
      Home
    </button>
  </a>
</div>

</body>

</html>
