from flask import Flask, render_template, jsonify, request

app = Flask(__name__)

# Initial detected object
detected_object = "None"

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/update', methods=['POST'])
def update():
    global detected_object
    detected_object = request.json.get('object_name', 'None')
    return jsonify(success=True)

@app.route('/get_object')
def get_object():
    return jsonify(object_name=detected_object)

if __name__ == '__main__':
    app.run(debug=True)
