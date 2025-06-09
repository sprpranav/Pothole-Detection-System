import numpy as np
import tensorflow as tf
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dense, Flatten
from tensorflow.keras.preprocessing.image import ImageDataGenerator
import os

# Define dataset path
dataset_path = "D:\\Projects\\Pothole System\\archive"  # Ensure you have 'pothole' and 'normal' folders inside

# Data preprocessing
datagen = ImageDataGenerator(rescale=1./255, validation_split=0.2)

train_generator = datagen.flow_from_directory(
    dataset_path,
    target_size=(64, 64),
    batch_size=32,
    class_mode="binary",
    subset="training"
)

val_generator = datagen.flow_from_directory(
    dataset_path,
    target_size=(64, 64),
    batch_size=32,
    class_mode="binary",
    subset="validation"
)

# ANN Model
model = Sequential([
    Flatten(input_shape=(64, 64, 3)),
    Dense(128, activation="relu"),
    Dense(64, activation="relu"),
    Dense(1, activation="sigmoid")  # Binary classification (pothole or not)
])

model.compile(optimizer="adam", loss="binary_crossentropy", metrics=["accuracy"])

# Train model
model.fit(train_generator, validation_data=val_generator, epochs=10)

# Save trained model
model.save("pothole_model.h5")
print("Model training completed and saved as pothole_model.h5")
