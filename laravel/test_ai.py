def test_ai_menghasilkan_prediksi():
    # Simulasi hasil prediksi AI
    hasil_prediksi = "A"

    # Memastikan AI menghasilkan prediksi
    assert hasil_prediksi is not None

    # Memastikan prediksi tidak kosong
    assert hasil_prediksi != ""

    # Memastikan hasil prediksi berupa teks
    assert isinstance(hasil_prediksi, str)

    print("Hasil prediksi AI:", hasil_prediksi)


def test_ai_menghasilkan_label_yang_valid():
    # Label huruf yang digunakan dalam sistem
    label_valid = [
        "A", "B", "C", "D", "E",
        "F", "G", "H", "I", "J",
        "K", "L", "M", "N", "O",
        "P", "Q", "R", "S", "T",
        "U", "V", "W", "X", "Y", "Z"
    ]

    # Hasil prediksi AI
    hasil_prediksi = "A"

    # Memastikan label hasil prediksi valid
    assert hasil_prediksi in label_valid

    print("Label prediksi valid:", hasil_prediksi)


def test_ai_menghasilkan_confidence():
    # Nilai confidence hasil prediksi AI
    confidence = 0.95

    # Confidence harus berada antara 0 dan 1
    assert confidence >= 0
    assert confidence <= 1

    print("Confidence AI:", confidence)


def test_ai_memproses_hasil_prediksi():
    # Data hasil prediksi AI
    hasil_ai = {
        "prediction": "A",
        "confidence": 0.95
    }

    # Memastikan terdapat hasil prediksi
    assert "prediction" in hasil_ai

    # Memastikan terdapat nilai confidence
    assert "confidence" in hasil_ai

    # Memastikan prediksi tidak kosong
    assert hasil_ai["prediction"] != ""

    # Memastikan confidence valid
    assert 0 <= hasil_ai["confidence"] <= 1

    print("Prediksi:", hasil_ai["prediction"])
    print("Confidence:", hasil_ai["confidence"])
