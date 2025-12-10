from flask import Flask, jsonify, render_template
import subprocess

app = Flask(__name__)

# Mapping of exercise actions to Python scripts
EXERCISE_SCRIPTS = {
    "lateral-rise": "exercise/lateral2.py",
    "alt-dumbbell-curls": "exercise/alternative2.py",
    "barbell-row": "exercise/barbell2.py",
    "push-up": "exercise/Pushup.py",
    "squats": "exercise/squat.py",
    "shoulder-press": "exercise/Shoulder_press.py",
    "tricep-dips": "exercise/Tricep_Dips.py"
}

@app.route('/')
def home():
    return render_template('Exercise.html')

@app.route('/run-exercise/<action>', methods=['GET'])
def run_exercise(action):
    script = EXERCISE_SCRIPTS.get(action)
    if script:
        try:
            # Log the action and script being executed
            print(f"Running script for action: {action}, Script: {script}")
            
            # Run the script and capture output
            result = subprocess.run(["python", script], capture_output=True, text=True)
            if result.returncode == 0:
                return jsonify({"output": result.stdout.strip()})
            else:
                return jsonify({"error": result.stderr.strip()})
        except Exception as e:
            return jsonify({"error": str(e)})
    else:
        return jsonify({"error": f"No script found for action: {action}"}), 400

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)

