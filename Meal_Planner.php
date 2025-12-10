<?php
// Meal plan and macro calculation based on user input
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $goal = $_POST['goal'];  // Weight loss, muscle gain, etc.
    $age = (int)$_POST['age'];
    $weight = (float)$_POST['weight'];
    $height = (float)$_POST['height'];
    $activityLevel = $_POST['activityLevel'];

    // Basic BMR calculation (Mifflin-St Jeor Equation for males)
    $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) + 5;

    // Total Daily Energy Expenditure (TDEE) based on activity level
    switch ($activityLevel) {
        case 'sedentary':
            $tdee = $bmr * 1.2;
            break;
        case 'light':
            $tdee = $bmr * 1.375;
            break;
        case 'moderate':
            $tdee = $bmr * 1.55;
            break;
        case 'active':
            $tdee = $bmr * 1.725;
            break;
        case 'very_active':
            $tdee = $bmr * 1.9;
            break;
        default:
            $tdee = $bmr;
    }

    // Calculate calories based on goals
    if ($goal == 'weight_loss') {
        $calories = $tdee - 500;  // 500-calorie deficit
    } else if ($goal == 'muscle_gain') {
        $calories = $tdee + 500;  // 500-calorie surplus
    } else {
        $calories = $tdee;
    }

    // Macros calculation
    $protein = round($weight * 2.2, 1); // Protein in grams (2.2g per kg)
    $fats = round(($calories * 0.25) / 9, 1); // 25% of calories from fat, convert to grams
    $carbs = round(($calories - ($protein * 4 + $fats * 9)) / 4, 1); // Remaining calories from carbs in grams

    // Calculate BMI = weight (kg) / height(m)^2
    $heightMeters = $height / 100;
    $bmi = round($weight / ($heightMeters * $heightMeters), 1);

    // BMI category
    if ($bmi < 18.5) {
        $bmiCategory = 'Underweight';
    } else if ($bmi < 25) {
        $bmiCategory = 'Normal weight';
    } else if ($bmi < 30) {
        $bmiCategory = 'Overweight';
    } else {
        $bmiCategory = 'Obese';
    }

    // Prepare result array for easy access in HTML + JS
    $result = [
        'calories' => round($calories),
        'protein' => $protein,
        'fats' => $fats,
        'carbs' => $carbs,
        'bmi' => $bmi,
        'bmiCategory' => $bmiCategory,
    ];
} else {
    $result = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Meal Planner & Macro Calculator</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #1f2937; /* Dark background */
            color: #d1d5db; /* Light text */
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 40px;
            padding-bottom: 40px;
        }

        .container {
            width: 100%;
            max-width: 700px;
            padding: 30px 40px;
            background-color: #2d3748; /* Card background */
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        h1 {
            color: #34a853; /* Accent green */
            font-size: 2.4rem;
            font-weight: 700;
            margin-bottom: 25px;
            text-align: center;
        }

        .form-label {
            color: #a0aec0;
            font-weight: 500;
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
            outline: none;
        }

        .btn-primary {
            background-color: #16a085;
            border: none;
            padding: 12px 25px;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #138e75;
        }

        .result {
            margin-top: 30px;
            font-size: 1.3rem;
            font-weight: 600;
            background-color: #1c2733;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(22, 160, 133, 0.5);
        }

        canvas {
            margin-top: 20px;
            max-width: 400px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        @media (max-width: 576px) {
            .container {
                padding: 20px 20px;
            }
            h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Macro Calculator & Meal Planner</h1>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="goal" class="form-label">Goal</label>
                <select name="goal" id="goal" class="form-select" required>
                    <option value="weight_loss">Weight Loss</option>
                    <option value="muscle_gain">Muscle Gain</option>
                    <option value="maintain">Maintain Weight</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" name="age" id="age" min="10" max="100" required />
            </div>

            <div class="mb-3">
                <label for="weight" class="form-label">Weight (kg)</label>
                <input type="number" class="form-control" name="weight" id="weight" step="0.1" min="20" max="300" required />
            </div>

            <div class="mb-3">
                <label for="height" class="form-label">Height (cm)</label>
                <input type="number" class="form-control" name="height" id="height" step="0.1" min="50" max="250" required />
            </div>

            <div class="mb-3">
                <label for="activityLevel" class="form-label">Activity Level</label>
                <select name="activityLevel" id="activityLevel" class="form-select" required>
                    <option value="sedentary">Sedentary (little or no exercise)</option>
                    <option value="light">Light (1-3 days/week)</option>
                    <option value="moderate">Moderate (3-5 days/week)</option>
                    <option value="active">Active (6-7 days/week)</option>
                    <option value="very_active">Very Active (hard exercise daily)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Calculate</button>

            <div style="display: flex; justify-content: center; margin-top: 30px;">
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
</div>

        </form>

        <?php if ($result): ?>
            <div class="result mt-4">
                <p><strong>Calories:</strong> <?= $result['calories'] ?> kcal</p>
                <p><strong>Protein:</strong> <?= $result['protein'] ?> g</p>
                <p><strong>Fats:</strong> <?= $result['fats'] ?> g</p>
                <p><strong>Carbs:</strong> <?= $result['carbs'] ?> g</p>
                <p><strong>BMI:</strong> <?= $result['bmi'] ?> (<?= $result['bmiCategory'] ?>)</p>

                <canvas id="macroChart"></canvas>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($result): ?>
    <script>
        const ctx = document.getElementById('macroChart').getContext('2d');

        const data = {
            labels: ['Protein (g)', 'Fats (g)', 'Carbs (g)'],
            datasets: [{
                data: [<?= $result['protein'] ?>, <?= $result['fats'] ?>, <?= $result['carbs'] ?>],
                backgroundColor: [
                    '#34a853',  // green for protein
                    '#f4b400',  // yellow for fats
                    '#4285f4'   // blue for carbs
                ],
                hoverOffset: 30
            }]
        };

        const config = {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#d1d5db', font: { size: 14, weight: 'bold' } }
                    },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + ' g';
                            }
                        }
                    }
                }
            }
        };

        new Chart(ctx, config);
    </script>
    <?php endif; ?>

    

</body>
</html>
