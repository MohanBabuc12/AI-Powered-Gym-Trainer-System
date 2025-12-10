import cv2
import mediapipe as mp
import numpy as np
import tkinter as tk
from tkinter import simpledialog, messagebox

# Initialize MediaPipe Pose and Drawing utilities
mp_drawing = mp.solutions.drawing_utils
mp_pose = mp.solutions.pose

# Function to calculate the angle between three points
def calculate_angle(a, b, c):
    a = np.array(a)  # First point
    b = np.array(b)  # Mid point
    c = np.array(c)  # End point

    radians = np.arctan2(c[1] - b[1], c[0] - b[0]) - np.arctan2(a[1] - b[1], a[0] - b[0])
    angle = np.abs(radians * 180.0 / np.pi)

    if angle > 180.0:
        angle = 360 - angle

    return angle

# Function to update Tkinter window
def update_tkinter_window(rep_count):
    count_label.config(text=f'Count: {rep_count}')
    if rep_count >= target_reps:
        messagebox.showinfo("Workout Finished", "Great job! Workout finished.")
        root.quit()  # Close Tkinter window

# Ask user for the number of reps
def ask_for_reps():
    reps = simpledialog.askinteger("Input", "How many reps to perform?", minvalue=1, maxvalue=100)
    if reps is None:
        messagebox.showwarning("Input Error", "Number of reps not specified. Exiting.")
        root.quit()
    return reps

# Initialize Tkinter
root = tk.Tk()
root.title("Tricep Dips Tracker")
root.geometry("300x100")

# Ask for target reps
target_reps = ask_for_reps()

count_label = tk.Label(root, text=f'Count: 0', font=('Helvetica', 24))
count_label.pack(pady=20)

# Initialize variables for counting reps and tracking progress
counter = 0
stage = None

# Start capturing video from the webcam
cap = cv2.VideoCapture(0)

# Set initial window size
window_name = 'Tricep Dips Detection'
cv2.namedWindow(window_name, cv2.WINDOW_NORMAL)
cv2.resizeWindow(window_name, 1280, 900)  # Set the window size (width, height)

# Setup MediaPipe Pose
with mp_pose.Pose(min_detection_confidence=0.5, min_tracking_confidence=0.5) as pose:
    while cap.isOpened():
        ret, frame = cap.read()

        if not ret:
            break

        # Convert the frame to RGB
        image = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        image.flags.writeable = False

        # Make pose detection
        results = pose.process(image)

        # Convert back to BGR for rendering
        image.flags.writeable = True
        image = cv2.cvtColor(image, cv2.COLOR_RGB2BGR)

        # Extract landmarks
        try:
            landmarks = results.pose_landmarks.landmark

            # Right side landmarks
            right_shoulder = [landmarks[mp_pose.PoseLandmark.RIGHT_SHOULDER.value].x,
                              landmarks[mp_pose.PoseLandmark.RIGHT_SHOULDER.value].y]
            right_elbow = [landmarks[mp_pose.PoseLandmark.RIGHT_ELBOW.value].x,
                           landmarks[mp_pose.PoseLandmark.RIGHT_ELBOW.value].y]
            right_wrist = [landmarks[mp_pose.PoseLandmark.RIGHT_WRIST.value].x,
                           landmarks[mp_pose.PoseLandmark.RIGHT_WRIST.value].y]

            # Left side landmarks
            left_shoulder = [landmarks[mp_pose.PoseLandmark.LEFT_SHOULDER.value].x,
                             landmarks[mp_pose.PoseLandmark.LEFT_SHOULDER.value].y]
            left_elbow = [landmarks[mp_pose.PoseLandmark.LEFT_ELBOW.value].x,
                          landmarks[mp_pose.PoseLandmark.LEFT_ELBOW.value].y]
            left_wrist = [landmarks[mp_pose.PoseLandmark.LEFT_WRIST.value].x,
                          landmarks[mp_pose.PoseLandmark.LEFT_WRIST.value].y]

            # Calculate the angle at the elbows
            right_elbow_angle = calculate_angle(right_shoulder, right_elbow, right_wrist)
            left_elbow_angle = calculate_angle(left_shoulder, left_elbow, left_wrist)

            # Print the angles for debugging
            print(f'Right Elbow Angle: {right_elbow_angle}')
            print(f'Left Elbow Angle: {left_elbow_angle}')

            # Define the target angle ranges for a proper tricep dip
            min_dip_angle = 90  # Minimum angle to be considered in the down position
            max_dip_angle = 150  # Maximum angle to be considered in the down position

            # Tricep dips counter logic
            if right_elbow_angle < min_dip_angle and left_elbow_angle < min_dip_angle:
                stage = "down"
                print('Stage: Down')
            if right_elbow_angle > max_dip_angle and left_elbow_angle > max_dip_angle and stage == "down":
                stage = "up"
                counter += 1
                print(f'Dips: {counter}')
                print('Stage: Up')
                update_tkinter_window(counter)  # Update Tkinter window with rep count

            # Draw the rep count on the image
            cv2.rectangle(image, (0, 0), (300, 100), (245, 117, 16), -1)
            cv2.putText(image, 'DIPS', (15, 30),
                        cv2.FONT_HERSHEY_SIMPLEX, 0.75, (0, 0, 0), 2, cv2.LINE_AA)
            cv2.putText(image, f'Count: {counter}',
                        (10, 70),
                        cv2.FONT_HERSHEY_SIMPLEX, 1.5, (255, 255, 255), 2, cv2.LINE_AA)

            # Draw pose landmarks on the image
            mp_drawing.draw_landmarks(image, results.pose_landmarks, mp_pose.POSE_CONNECTIONS,
                                      mp_drawing.DrawingSpec(color=(0, 0, 255), thickness=2, circle_radius=4),
                                      mp_drawing.DrawingSpec(color=(255, 255, 255), thickness=2, circle_radius=2))

            # Show the image with landmarks and feedback
            cv2.imshow(window_name, image)

        except Exception as e:
            print(f'Error: {e}')

        # Exit on pressing 'q'
        if cv2.waitKey(10) & 0xFF == ord('q'):
            break

    cap.release()
    cv2.destroyAllWindows()
