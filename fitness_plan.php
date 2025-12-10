<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Plan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1f2937;
            color: #d1d5db;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .fitness-plan-container {
            width: 100%;
            max-width: 500px;
            padding: 30px 40px;
            background-color: #2d3748;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        .fitness-plan-container h1 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 2rem;
            font-weight: bold;
            color: #34a853;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 1rem;
            color: #a0aec0;
        }

        .input-group input, .input-group textarea, .input-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #4a5568;
            background-color: #1a202c;
            color: #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .input-group input:focus, .input-group textarea:focus, .input-group select:focus {
            outline: none;
            border-color: #34a853;
            box-shadow: 0 0 8px rgba(52, 168, 83, 0.6);
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: #34a853;
            color: #fff;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #2c9c46;
            transform: scale(1.03);
        }

        .cancel-button {
            margin-top: 15px;
            width: 100%;
            padding: 12px;
            background-color: #e53e3e;
            color: #fff;
            font-size: 1.2rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .cancel-button:hover {
            background-color: #c53030;
        }
    </style>
</head>
<body>
    <div class="fitness-plan-container">
        <h1>Create Fitness Plan</h1>
        <form action="save_fitness_plan.php" method="POST">
            <!-- Plan Type Selection -->
            <div class="input-group">
                <label for="plan_name">Plan Type:</label>
                <select id="plan_name" name="plan_name" required>
                    <option value="" selected disabled>Select a Plan Type</option>
                    <option value="Weight Gain">Weight Gain</option>
                    <option value="Weight Loss">Weight Loss</option>
                    <option value="Cardio">Cardio</option>
                    <option value="Strength Training">Strength Training</option>
                    <option value="Flexibility">Flexibility</option>
                    <option value="Endurance">Endurance</option>
                </select>
            </div>

            <!-- Plan Details Input (with dropdown) -->
            <div class="input-group">
                <label for="plan_details">Plan Details:</label>
                <select id="plan_details" name="plan_details" required>
                    <option value="" selected disabled>Select Plan Details</option>
                    <option value="Muscle Building">Muscle Building</option>
                    <option value="Fat Loss">Fat Loss</option>
                    <option value="Cardio Endurance">Cardio Endurance</option>
                    <option value="Flexibility & Mobility">Flexibility & Mobility</option>
                    <option value="Total Body Strength">Total Body Strength</option>
                    <option value="Core Strength">Core Strength</option>
                    <option value="HIIT">High-Intensity Interval Training (HIIT)</option>
                    <option value="Cross-Training">Cross-Training</option>
                    <option value="Sport-Specific">Sport-Specific</option>
                </select>
            </div>

            <!-- Plan Duration Input (weeks or months) -->
            <div class="input-group">
                <label for="plan_duration">Plan Duration:</label>
                <select id="plan_duration" name="plan_duration" required>
                    <option value="" selected disabled>Select Plan Duration</option>
                    <option value="1 week">1 Week</option>
                    <option value="2 weeks">2 Weeks</option>
                    <option value="3 weeks">3 Weeks</option>
                    <option value="4 weeks">4 Weeks</option>
                    <option value="1 month">1 Month</option>
                    <option value="2 months">2 Months</option>
                    <option value="3 months">3 Months</option>
                    <option value="4 months">4 Months</option>
                    <option value="5 months">5 Months</option>
                    <option value="6 months">6 Months</option>
                    <!-- You can add more options here -->
                </select>
            </div>

            <!-- Start Date Input (set default to today's date) -->
            <div class="input-group">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo date('Y-m-d'); ?>" required readonly>
            </div>

            <!-- End Date Input (auto-calculated based on Plan Duration) -->
            <div class="input-group">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required readonly>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success w-100">Save Workout</button>
        </form>

        <!-- Cancel Button -->
        <button class="btn btn-danger w-100 mt-3" onclick="history.back()">Cancel</button>
        <button class="btn btn-secondary w-100 mt-3" onclick="window.location.href='HOME.html'">Back to Home</button>
    </div>

    <script>
        // Function to calculate end date based on selected duration
        document.getElementById('plan_duration').addEventListener('change', function() {
            const duration = this.value;
            const startDate = new Date();
            startDate.setDate(startDate.getDate() + 1); // Set start date to tomorrow (if needed)

            let endDate = new Date(startDate);

            // Calculate end date based on the selected plan duration
            if (duration.includes('week')) {
                const weeks = parseInt(duration);
                endDate.setDate(startDate.getDate() + (weeks * 7)); // Add weeks
            } else if (duration.includes('month')) {
                const months = parseInt(duration);
                endDate.setMonth(startDate.getMonth() + months); // Add months
            }

            // Set calculated dates
            document.getElementById('start_date').value = startDate.toISOString().split('T')[0];
            document.getElementById('end_date').value = endDate.toISOString().split('T')[0];
        });
    </script>
</body>
</html>
