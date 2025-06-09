import sys
import numpy as np
import cv2
import tensorflow as tf
from tensorflow.keras.models import load_model

# Load trained model
model = load_model("pothole_model.h5")

def detect_pothole(image_path):
    try:
        # Load and preprocess image
        image = cv2.imread(image_path)
        image = cv2.resize(image, (64, 64))
        image = np.array(image) / 255.0  # Normalize
        image = np.expand_dims(image, axis=0)  # Reshape for model

        # Predict pothole
        prediction = model.predict(image)[0][0]
        if prediction > 0.5:
            return "Pothole Detected"
        else:
            return "No Pothole"
    except Exception as e:
        return f"Error: {str(e)}"

# Get image path from PHP script
if __name__ == "__main__":
    image_path = sys.argv[1]  # PHP passes image path as argument
    result = detect_pothole(image_path)
    print(result)  # Send output back to PHP
