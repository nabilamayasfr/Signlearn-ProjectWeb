@extends('layout.app')

@section('title', 'SignLearn - Belajar Huruf ' . strtoupper($huruf))

@section('content')

@include('layout.navbar')

<div class="min-h-screen flex flex-col" style="background-color: #FEE6F2;">

    <div class="flex-1 flex flex-col items-center px-6 py-6 max-w-lg mx-auto w-full">

        {{-- Back Button --}}
        <div class="w-full flex items-center gap-2 mb-6">
            <a href="{{ route('pembelajaran') }}"
               class="flex items-center gap-2 text-gray-700 font-bold text-sm hover:text-pink-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ strtoupper($modul) }}
            </a>
        </div>

        {{-- Progress Bar --}}
        @php
            $alphabet     = range('A', 'Z');
            $currentIndex = array_search(strtoupper($huruf), $alphabet);
            $progressPercent = (($currentIndex + 1) / 26) * 100;
            $nextHuruf    = $currentIndex < 25 ? $alphabet[$currentIndex + 1] : null;
        @endphp

        <div class="w-full bg-pink-200 rounded-full h-2 mb-6">
            <div class="h-2 rounded-full transition-all duration-300"
                 style="width: {{ $progressPercent }}%;
                        background: linear-gradient(90deg, #F472B6, #DB2777);">
            </div>
        </div>

        {{-- Timer + Huruf --}}
        <div class="flex items-center justify-between w-full mb-6">

            {{-- Huruf Target --}}
            <div class="w-16 h-16 bg-white rounded-2xl shadow-md flex items-center
                        justify-center border border-pink-100">
                <span class="text-3xl font-extrabold text-gray-800">
                    {{ strtoupper($huruf) }}
                </span>
            </div>

            {{-- Timer Display ← INI YANG HILANG --}}
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 rounded-2xl bg-white shadow-md border border-pink-100
                            flex items-center justify-center">
                    <span id="timerText"
                          class="text-3xl font-extrabold"
                          style="color: #C07EB5;">5</span>
                </div>
                <p class="text-xs text-gray-400 mt-1">detik</p>
            </div>

        </div>

        {{-- Instruksi --}}
        <p class="text-gray-500 text-sm mb-3">Praktikkan gesture huruf berikut</p>

        {{-- Kamera --}}
        <div class="w-full bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">

            <div class="relative w-full bg-black" style="height: 280px;">

                <video id="cameraFeed" autoplay playsinline
                       class="w-full h-full object-cover transition duration-300"></video>

                <canvas id="captureCanvas" width="480" height="360" class="hidden"></canvas>

                {{-- Corner markers --}}
                <div class="absolute top-3 left-3 w-8 h-8 border-t-2 border-l-2 border-green-400 rounded-tl"></div>
                <div class="absolute top-3 right-3 w-8 h-8 border-t-2 border-r-2 border-green-400 rounded-tr"></div>
                <div class="absolute bottom-3 left-3 w-8 h-8 border-b-2 border-l-2 border-green-400 rounded-bl"></div>
                <div class="absolute bottom-3 right-3 w-8 h-8 border-b-2 border-r-2 border-green-400 rounded-br"></div>

                {{-- Center line --}}
                <div class="absolute top-0 bottom-0 left-1/2 w-px bg-pink-400 opacity-40"></div>

                {{-- Timer Overlay saat waktu habis ← INI YANG HILANG --}}
                <div id="timerOverlay"
                     class="absolute inset-0 bg-black bg-opacity-60
                            flex-col items-center justify-center hidden">
                    <p class="text-white text-lg font-bold mb-4">⏱ Waktu Habis!</p>
                    <button onclick="resetPractice()"
                            class="px-6 py-2 rounded-xl bg-pink-500 text-white
                                   font-bold text-sm hover:bg-pink-600 transition">
                        🔄 Ulangi
                    </button>
                </div>

                {{-- Camera Placeholder --}}
                <div id="cameraPlaceholder"
                     class="absolute inset-0 hidden items-center justify-center
                            bg-gray-800 bg-opacity-50">
                    <p class="text-white text-xs">Kamera tidak tersedia</p>
                </div>

            </div>

            {{-- Status Detection --}}
            <div class="px-4 py-3 bg-gray-50 text-center border-t border-gray-100">
                <p id="detectionStatus" class="text-gray-500 text-sm font-medium">
                    Mendeteksi Tangan...
                </p>
            </div>

        </div>

        {{-- Tombol Next --}}
        <div class="w-full mt-6">
            @if($nextHuruf)
                <a href="{{ route('pembelajaran.huruf', ['modul' => $modul, 'huruf' => strtolower($nextHuruf)]) }}"
                   class="w-full py-4 rounded-2xl text-sm font-bold text-white transition
                          hover:opacity-90 text-center block shadow-md"
                   style="background: linear-gradient(135deg, #F472B6, #DB2777);">
                    Huruf Berikutnya →
                </a>
            @else
                <a href="{{ route('pembelajaran.index') }}"
                   class="w-full py-4 rounded-2xl text-sm font-bold text-white transition
                          hover:opacity-90 text-center block shadow-md"
                   style="background: linear-gradient(135deg, #F472B6, #DB2777);">
                    Selesai ✓
                </a>
            @endif
        </div>

    </div>
</div>

@push('scripts')
<script>
    // ── STATE ────────────────────────────────────────────
    let timeLeft         = 30;   // ← 30 detik (lebih wajar dari 5 detik)
    let timerInterval    = null;
    let detectionInterval = null;
    let cameraStream     = null;
    let isProcessing     = false;
    let sudahDisimpan    = false; // ← guard supaya tidak simpan 2x

    const timerText       = document.getElementById('timerText');
    const detectionStatus = document.getElementById('detectionStatus');
    const video           = document.getElementById('cameraFeed');
    const canvas          = document.getElementById('captureCanvas');
    const timerOverlay    = document.getElementById('timerOverlay');

    const TARGET_HURUF = "{{ strtoupper($huruf) }}";
    const MODULE       = "{{ strtoupper($modul) }}";
    const FASTAPI_URL  = "http://127.0.0.1:8000/predict";

    let lastPredictions = [];

    // ── SIMPAN HASIL AI KE DATABASE ──────────────────────
    async function simpanHasilAI(language, huruf, skorAI, prediksiAI) {
        if (sudahDisimpan) return; // ← jangan simpan 2x
        sudahDisimpan = true;

        try {
            const res = await fetch('/praktik/simpan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    language:    language,
                    huruf:       huruf,
                    skor_ai:     skorAI,
                    prediksi_ai: prediksiAI,
                }),
            });

            const data = await res.json();
            console.log('✅ Hasil praktik tersimpan:', data);

        } catch (err) {
            console.warn('⚠️ Gagal menyimpan hasil praktik:', err);
            sudahDisimpan = false; // reset supaya bisa dicoba lagi
        }
    }

    // ── TIMER ────────────────────────────────────────────
    function startTimer() {
        if (timerInterval) clearInterval(timerInterval);

        timeLeft = 30;
        if (timerText) {
            timerText.innerText    = timeLeft;
            timerText.style.color  = '#C07EB5';
        }

        timerInterval = setInterval(() => {
            timeLeft--;

            if (timerText) {
                timerText.innerText   = timeLeft > 0 ? timeLeft : 0;
                // Warna berubah merah saat < 10 detik
                timerText.style.color = timeLeft <= 10 ? '#EF4444' : '#C07EB5';
            }

            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                stopDetection();

                if (timerText) timerText.innerText = '0';

                detectionStatus.innerText    = 'Waktu habis! Klik Ulangi untuk mencoba lagi.';
                detectionStatus.style.color  = '#EF4444';
                video.style.filter           = 'blur(4px)';

                // Tampilkan overlay
                if (timerOverlay) {
                    timerOverlay.classList.remove('hidden');
                    timerOverlay.style.display = 'flex';
                }

                // Simpan ke database dengan skor 0
                const prediksiTerakhir = lastPredictions.length > 0
                    ? getMostFrequentPrediction(lastPredictions)
                    : null;

                simpanHasilAI(
                    MODULE.toLowerCase(),
                    TARGET_HURUF,
                    0.0,
                    prediksiTerakhir
                );
            }
        }, 1000);
    }

    // ── KAMERA ───────────────────────────────────────────
    async function startCamera() {
        try {
            cameraStream = await navigator.mediaDevices.getUserMedia({
                video: true, audio: false
            });

            video.srcObject = cameraStream;
            document.getElementById('cameraPlaceholder').style.display = 'none';

            detectionStatus.innerText   = 'Kamera aktif. Tunjukkan gesture tangan...';
            detectionStatus.style.color = '#6B7280';

            startDetection();

        } catch (err) {
            console.warn('Kamera tidak bisa diakses:', err);
            document.getElementById('cameraPlaceholder').style.display = 'flex';
            detectionStatus.innerText   = 'Izinkan akses kamera untuk mendeteksi isyarat.';
            detectionStatus.style.color = '#EF4444';
        }
    }

    // ── DETEKSI REALTIME ─────────────────────────────────
    function startDetection() {
        if (detectionInterval) clearInterval(detectionInterval);
        detectionInterval = setInterval(() => captureAndPredict(), 700);
    }

    function stopDetection() {
        if (detectionInterval) {
            clearInterval(detectionInterval);
            detectionInterval = null;
        }
    }

    async function captureAndPredict() {
        if (isProcessing || !video.srcObject) return;
        isProcessing = true;

        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        canvas.toBlob(async function(blob) {
            if (!blob) { isProcessing = false; return; }

            const formData = new FormData();
            formData.append('module', MODULE);
            formData.append('file', blob, 'frame.jpg');

            try {
                const response = await fetch(FASTAPI_URL, {
                    method: 'POST', body: formData
                });
                const result = await response.json();
                handlePredictionResult(result);

            } catch (error) {
                console.error('Gagal menghubungi FastAPI:', error);
                detectionStatus.innerText   = 'Server AI tidak aktif. Pastikan FastAPI menyala.';
                detectionStatus.style.color = '#EF4444';
            }

            isProcessing = false;
        }, 'image/jpeg', 0.8);
    }

    // ── PROSES HASIL PREDIKSI ────────────────────────────
    function handlePredictionResult(result) {
        if (!result.success) {
            detectionStatus.innerText   = result.message || 'Tangan tidak terdeteksi.';
            detectionStatus.style.color = '#6B7280';
            return;
        }

        const predicted         = result.prediction.toUpperCase();
        const confidence        = result.confidence;
        const confidencePercent = (confidence * 100).toFixed(1);

        lastPredictions.push(predicted);
        if (lastPredictions.length > 5) lastPredictions.shift();

        const finalPrediction = getMostFrequentPrediction(lastPredictions);

        if (confidence < 0.70) {
            detectionStatus.innerText =
                `Terdeteksi ${predicted} (${confidencePercent}%) — confidence rendah. Perjelas posisi tangan.`;
            detectionStatus.style.color = '#F59E0B';
            return;
        }

        if (finalPrediction === TARGET_HURUF) {
            detectionStatus.innerText =
                `✅ Benar! Huruf ${TARGET_HURUF} terdeteksi dengan skor ${confidencePercent}%`;
            detectionStatus.style.color = '#22C55E';

            stopDetection();
            if (timerInterval) clearInterval(timerInterval);

            // Simpan ke database — gesture berhasil
            simpanHasilAI(
                MODULE.toLowerCase(),
                TARGET_HURUF,
                confidence,
                predicted
            );

        } else {
            detectionStatus.innerText =
                `Terdeteksi ${finalPrediction} (${confidencePercent}%). Target: ${TARGET_HURUF}`;
            detectionStatus.style.color = '#EF4444';
        }
    }

    // ── VOTING 5 FRAME TERAKHIR ──────────────────────────
    function getMostFrequentPrediction(predictions) {
        const counts = {};
        predictions.forEach(p => counts[p] = (counts[p] || 0) + 1);
        return Object.keys(counts).reduce((a, b) => counts[a] > counts[b] ? a : b);
    }

    // ── RESET ────────────────────────────────────────────
    function resetPractice() {
        video.style.filter = '';

        if (timerOverlay) {
            timerOverlay.classList.add('hidden');
            timerOverlay.style.display = 'none';
        }

        detectionStatus.innerText   = 'Mendeteksi Tangan...';
        detectionStatus.style.color = '';

        lastPredictions = [];
        sudahDisimpan   = false; // ← reset guard supaya bisa simpan lagi

        startTimer();
        startDetection();
    }

    // ── INIT ─────────────────────────────────────────────
    startCamera();
    startTimer();
</script>
@endpush

@include('layout.footer')
@endsection