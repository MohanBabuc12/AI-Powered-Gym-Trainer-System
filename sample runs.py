import cv2
from ultralytics import YOLO

# Load your YOLO model with the trained weights
model_path = "best.pt"  # Replace with the path to your weights file
yolo_model = YOLO(model_path)

# Start the webcam for real-time detection
cap = cv2.VideoCapture(0)  # Use 0 for the default webcam

while cap.isOpened():
    ret, frame = cap.read()
    if not ret:
        print("Failed to grab frame from the webcam.")
        break

    # Perform object detection on the frame
    results = yolo_model(frame)

    # Extract results for bounding boxes, class labels, and confidences
    boxes = results[0].boxes.xyxy  # Bounding box coordinates
    labels = results[0].boxes.cls  # Class IDs
    confidences = results[0].boxes.conf  # Confidence scores

    # Draw the detections on the frame
    for box, label, conf in zip(boxes, labels, confidences):
        if conf > 0.6:  # Set a confidence threshold
            x1, y1, x2, y2 = map(int, box)  # Convert coordinates to integers
            class_name = yolo_model.names[int(label)]  # Get class name

            # Draw the bounding box and label
            color = (0, 255, 0)  # Green for bounding boxes
            cv2.rectangle(frame, (x1, y1), (x2, y2), color, 2)
            cv2.putText(frame, f"{class_name} {conf:.2f}", (x1, y1 - 10),
                        cv2.FONT_HERSHEY_SIMPLEX, 0.5, color, 2)

    # Display the annotated frame
    cv2.imshow("YOLOv8 Real-Time Detection", frame)

    # Press 'q' to exit the loop
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

# Release resources
cap.release()
cv2.destroyAllWindows()
