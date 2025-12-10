import cv2
import threading
import requests
from flask import Flask, render_template, jsonify, request
from ultralytics import YOLO

# Flask server setup
app = Flask(__name__)

# Global variable to store detected objects
detected_object = "None"

# Home route
@app.route('/')
def index():
    return render_template('index.html')  # Ensure 'index.html' exists in the templates folder

# Food Tracker route
@app.route('/food-tracker')
def food_tracker():
    return render_template('food_tracker.html')  # Add a food_tracker.html page in the templates folder

# Endpoint to update detected objects
@app.route('/update', methods=['POST'])
def update():
    global detected_object
    detected_object = request.json.get('object_name', 'None')
    return jsonify(success=True)

# Endpoint to get the latest detected object
@app.route('/get_object')
def get_object():
    return jsonify(object_name=detected_object)

# YOLO detection function
def start_yolo():
    global detected_object
    FLASK_SERVER_URL = 'http://127.0.0.1:5001/update'  # Ensure this matches the Flask server port
    model_path = "best.pt"  # Path to your YOLO model weights
    yolo_model = YOLO(model_path)

    cap = cv2.VideoCapture(0)  # Start the webcam

    while cap.isOpened():
        ret, frame = cap.read()
        if not ret:
            print("Failed to grab frame from the webcam.")
            break

        # Perform object detection
        results = yolo_model(frame)
        boxes = results[0].boxes.xyxy
        labels = results[0].boxes.cls
        confidences = results[0].boxes.conf

        detected_objects = []

        for box, label, conf in zip(boxes, labels, confidences):
            if conf > 0.6:  # Confidence threshold
                x1, y1, x2, y2 = map(int, box)
                class_name = yolo_model.names[int(label)]
                detected_objects.append(class_name)

                # Draw bounding boxes
                color = (0, 255, 0)
                cv2.rectangle(frame, (x1, y1), (x2, y2), color, 2)
                cv2.putText(frame, f"{class_name} {conf:.2f}", (x1, y1 - 10),
                            cv2.FONT_HERSHEY_SIMPLEX, 0.5, color, 2)

        # Send data to the Flask server
        if detected_objects:
            try:
                response = requests.post(FLASK_SERVER_URL, json={'object_name': detected_objects})
                if response.status_code != 200:
                    print(f"Failed to send data to Flask server: {response.status_code}")
            except requests.exceptions.RequestException as e:
                print(f"Error connecting to Flask server: {e}")

        # Display the frame with annotations
        cv2.imshow("YOLOv8 Real-Time Detection", frame)

        if cv2.waitKey(1) & 0xFF == ord('q'):
            break

    cap.release()
    cv2.destroyAllWindows()

# Function to start the Flask server
def start_flask():
    app.run(port=5001, debug=False, use_reloader=False)  # Running on port 5001 to avoid conflict

# Start both Flask and YOLO in separate threads
if __name__ == '__main__':
    threading.Thread(target=start_flask).start()  # Start Flask server
    start_yolo()  # Start YOLO detection
