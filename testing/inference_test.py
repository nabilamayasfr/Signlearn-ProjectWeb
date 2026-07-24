from locust import HttpUser, task, between
import os
import sys
import time
import numpy as np
import tensorflow as tf

BASE_DIR = os.path.abspath(
    os.path.join(
        os.path.dirname(__file__),
        ".."
    )
)

FASTAPI_DIR = os.path.join(
    BASE_DIR,
    "fastapi"
)

sys.path.append(FASTAPI_DIR)

from utils.preprocess import extract_landmarks_from_image


class SignLearnAIUser(HttpUser):

    wait_time = between(1, 2)

    @task(1)
    def test_bisindo_prediction(self):

        image_path = os.path.join(
            BASE_DIR,
            "laravel",
            "public",
            "assets",
            "alphabet",
            "bisindo",
            "a.png"
        )

        with open(image_path, "rb") as image:

            response = self.client.post(
                "/predict",
                data={
                    "module": "BISINDO"
                },
                files={
                    "file": (
                        "a.png",
                        image,
                        "image/png"
                    )
                },
                name="AI Prediction BISINDO"
            )

        if response.status_code != 200:

            response.failure(
                f"Status {response.status_code}: "
                f"{response.text}"
            )


    @task(1)
    def test_sibi_prediction(self):

        image_path = os.path.join(
            BASE_DIR,
            "laravel",
            "public",
            "assets",
            "alphabet",
            "sibi",
            "a.png"
        )

        with open(image_path, "rb") as image:

            response = self.client.post(
                "/predict",
                data={
                    "module": "SIBI"
                },
                files={
                    "file": (
                        "a.png",
                        image,
                        "image/png"
                    )
                },
                name="AI Prediction SIBI"
            )

        if response.status_code != 200:

            response.failure(
                f"Status {response.status_code}: "
                f"{response.text}"
            )


def test_inference_time():

    print("\n===== INFERENCE TEST =====")

    model_path = os.path.join(
        FASTAPI_DIR,
        "models",
        "BISINDO",
        "best_bisindo_model_fixed.keras"
    )

    image_path = os.path.join(
        BASE_DIR,
        "laravel",
        "public",
        "assets",
        "alphabet",
        "bisindo",
        "a.png"
    )

    print("Loading model...")

    model = tf.keras.models.load_model(
        model_path,
        compile=False
    )

    print("Model berhasil dimuat.")

    print("Membaca gambar...")

    with open(image_path, "rb") as image:
        image_bytes = image.read()

    print("Melakukan ekstraksi landmark...")

    features = extract_landmarks_from_image(
        image_bytes
    )

    if features is None:

        print(
            "Gagal: tangan tidak terdeteksi."
        )

        return

    print(
        "Landmark berhasil diekstraksi."
    )

    print(
        "Melakukan warm-up model..."
    )

    for _ in range(10):

        model.predict(
            features,
            verbose=0
        )

    print(
        "Warm-up selesai."
    )

    print(
        "Memulai pengujian inference "
        "sebanyak 100 kali..."
    )

    inference_times = []

    for i in range(100):

        start_time = time.perf_counter()

        model.predict(
            features,
            verbose=0
        )

        end_time = time.perf_counter()

        inference_time = (
            end_time - start_time
        ) * 1000

        inference_times.append(
            inference_time
        )

    average_time = np.mean(
        inference_times
    )

    max_time = np.max(
        inference_times
    )

    min_time = np.min(
        inference_times
    )

    print("\n===== HASIL PENGUJIAN =====")

    print(
        "Jumlah pengujian : 100"
    )

    print(
        f"Rata-rata        : "
        f"{average_time:.2f} ms"
    )

    print(
        f"Minimum          : "
        f"{min_time:.2f} ms"
    )

    print(
        f"Maksimum         : "
        f"{max_time:.2f} ms"
    )

    if average_time <= 60:

        print(
            "\nSTATUS INFERENCE: PASS"
        )

        print(
            "Model memenuhi requirement "
            "inference maksimal 60 ms."
        )

    else:

        print(
            "\nSTATUS INFERENCE: FAIL"
        )

        print(
            "Model tidak memenuhi requirement "
            "inference maksimal 60 ms."
        )


if __name__ == "__main__":

    test_inference_time()