@extends('layout.app')

@section('title', 'SignLearn - Belajar Huruf ' . strtoupper($huruf))

@section('content')

@php
    $alphabet = range('A', 'Z');
    $currentIndex = array_search(strtoupper($huruf), $alphabet);
    $progressPercent = (($currentIndex + 1) / 26) * 100;
    $nextHuruf = $currentIndex < 25 ? $alphabet[$currentIndex + 1] : null;
    $prevHuruf = $currentIndex > 0 ? $alphabet[$currentIndex - 1] : null;
    $windowStart = max(0, min($currentIndex - 2, 20));
    $displayList = array_slice($alphabet, $windowStart, 6, true);
@endphp

<div class="min-h-screen pb-6" style="background-color: #FEE6F2;">
    {{-- Top Bar --}}
    <div class="flex items-center justify-between px-6 py-3 bg-white border-b" style="border-color: rgba(219,39,119,0.15);">
        <a href="{{ route('pembelajaran.index') }}" class="flex items-center gap-2 text-pink-600 font-semibold text-sm hover:text-pink-800 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            {{ strtoupper($modul) }}
        </a>

        {{-- Progress Bar --}}
        <div class="flex flex-col items-center flex-1 mx-4">
            <p class="text-xs text-gray-400 font-medium mb-2">Progress Belajar</p>
            <div class="flex items-center justify-center">
                @foreach($displayList as $index => $letter)
                    <div class="flex flex-col items-center">
                        <a href="{{ route('praktik.huruf', ['modul' => $modul, 'huruf' => strtolower($letter)]) }}" class="flex flex-col items-center group">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all
                                {{ $index < $currentIndex ? 'bg-pink-500 text-white' : ($index === $currentIndex ? 'bg-white border-[3px] border-pink-500 text-pink-500' : 'bg-white border-2 border-gray-200 text-gray-300 group-hover:border-pink-300 group-hover:text-pink-400') }}">
                                @if($index < $currentIndex)
                                    <svg class="w-3 h-3" fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @else
                                    {{ $letter }}
                                @endif
                            </div>
                            <span class="text-xs mt-1 {{ $index === $currentIndex ? 'text-pink-500 font-semibold' : 'text-gray-400' }}">{{ $letter }}</span>
                        </a>
                    </div>
                    @if(!$loop->last)
                        <div class="w-5 h-0.5 mb-4 {{ $index < $currentIndex ? 'bg-pink-500' : 'bg-gray-200' }}"></div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Timer --}}
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4" style="color:#C07EB5;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
            </svg>
            <span id="timerText" class="text-2xl font-black" style="color: #C07EB5;">30</span>
            <span class="text-xs text-gray-400">detik</span>
        </div>
    </div>

    {{-- Progress Bar Bottom --}}
    <div class="w-full bg-pink-200" style="height:3px;">
        <div class="transition-all duration-300" style="height:3px; width: {{ $progressPercent }}%; background: linear-gradient(90deg, #F472B6, #DB2777);"></div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-5xl mx-auto px-6 py-5 grid grid-cols-1 lg:grid-cols-2 gap-5 items-start">
        {{-- Camera Section --}}
        <div>
            {{-- Camera Confirmation --}}
            <div id="cameraConfirm" class="flex flex-col items-center justify-center py-10 px-6 text-center bg-black rounded-2xl overflow-hidden" style="min-height: 340px;">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
                    </svg>
                </div>
                <p class="text-gray-300 text-sm mb-1">
                    Deteksi gesture huruf
                    <span class="font-bold text-pink-400">{{ strtoupper($huruf) }}</span>
                </p>
                <button onclick="mulaiKamera()" class="px-8 py-2.5 rounded-xl font-bold text-white text-sm shadow hover:opacity-90 transition" style="background: linear-gradient(135deg, #F472B6, #DB2777);">
                    Buka Kamera & Mulai
                </button>
            </div>

            {{-- Camera Active Area --}}
            <div id="cameraArea" class="hidden">
                <div class="relative w-full bg-black rounded-2xl overflow-hidden" style="height: 340px;">
                    <video id="cameraFeed" autoplay playsinline class="w-full h-full object-cover transition-all duration-700" style="transform: scaleX(-1);"></video>
                    <canvas id="captureCanvas" width="640" height="480" class="hidden"></canvas>

                    {{-- Corner Markers --}}
                    <div class="absolute top-3 left-3 w-7 h-7 border-t-2 border-l-2 border-green-400 rounded-tl"></div>
                    <div class="absolute top-3 right-3 w-7 h-7 border-t-2 border-r-2 border-green-400 rounded-tr"></div>
                    <div class="absolute bottom-3 left-3 w-7 h-7 border-b-2 border-l-2 border-green-400 rounded-bl"></div>
                    <div class="absolute bottom-3 right-3 w-7 h-7 border-b-2 border-r-2 border-green-400 rounded-br"></div>

                    {{-- Success Overlay --}}
                    <div id="successOverlay" class="absolute inset-0 flex-col items-center justify-center hidden transition-all duration-500 bg-black/55 backdrop-blur-sm">
                        <div id="successIcon" class="w-16 h-16 rounded-full flex items-center justify-center mb-3 transition-all duration-500 bg-gradient-to-br from-green-400 to-green-700 scale-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <h3 class="text-white text-xl font-extrabold mb-1">Hebat!</h3>
                        <p class="text-green-300 text-sm font-semibold mb-0.5">
                            Huruf <span class="text-white font-extrabold">{{ strtoupper($huruf) }}</span> berhasil!
                        </p>
                        <p id="successScore" class="text-gray-300 text-xs mb-5"></p>
                        <div class="flex flex-col gap-2 w-40">
                            @if($nextHuruf)
                                <a href="{{ route('praktik.huruf', ['modul' => $modul, 'huruf' => strtolower($nextHuruf)]) }}" class="w-full py-2.5 rounded-xl text-sm font-bold text-white text-center shadow hover:opacity-90 transition bg-gradient-to-r from-pink-500 to-pink-700">
                                    Huruf Berikutnya
                                </a>
                            @else
                                <a href="{{ route('pembelajaran.index') }}" class="w-full py-2.5 rounded-xl text-sm font-bold text-white text-center shadow hover:opacity-90 transition bg-gradient-to-r from-pink-500 to-pink-700">
                                    Selesai
                                </a>
                            @endif
                            <button onclick="resetPractice()" class="w-full py-2.5 rounded-xl text-sm font-bold text-white border border-white/40 hover:bg-white/10 transition">
                                Ulangi Latihan
                            </button>
                        </div>
                    </div>

                    {{-- Timer Overlay --}}
                    <div id="timerOverlay" class="absolute inset-0 bg-black/60 flex-col items-center justify-center hidden">
                        <p class="text-white text-base font-bold mb-3">Waktu Habis!</p>
                        <button onclick="resetPractice()" class="px-6 py-2 rounded-xl bg-pink-500 text-white font-bold text-sm hover:bg-pink-600 transition">
                            Ulangi
                        </button>
                    </div>

                    {{-- Camera Error Overlay --}}
                    <div id="cameraPlaceholder" class="absolute inset-0 hidden items-center justify-center bg-gray-800/80 flex-col gap-2">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                        <p class="text-white text-xs">Kamera tidak dapat diakses</p>
                        <button onclick="mulaiKamera()" class="text-xs text-pink-300 underline mt-1">Coba lagi</button>
                    </div>
                </div>

                {{-- Detection Status --}}
                <div class="px-4 py-3 bg-gray-50 text-center border-t border-gray-100 rounded-b-2xl">
                    <p id="detectionStatus" class="text-gray-500 text-sm font-medium">Mendeteksi Tangan...</p>
                </div>
            </div>
        </div>

        {{-- Instructions Panel --}}
        <div class="bg-white rounded-2xl shadow-sm border border-pink-50 p-5">
            <div class="flex items-center gap-2.5 mb-4">
                <div class="w-8 h-8 rounded-full flex items-center justify-center bg-pink-100">
                    <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/>
                    </svg>
                </div>
                <h2 class="text-sm font-bold text-gray-800">Tata Cara Praktik</h2>
            </div>

            <div class="flex flex-col gap-3 mb-4">
                @php
                    $tips = [
                        ['icon' => 'M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z', 'title' => 'Posisikan tangan di tengah frame', 'desc' => 'Pastikan seluruh tangan terlihat dalam area kamera dan tidak terpotong di tepi layar.'],
                        ['icon' => 'M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM9.75 4.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75v.75H9.75V4.5zM6.75 9.75a.75.75 0 01.75-.75h10.5a.75.75 0 01.75.75v9a.75.75 0 01-.75.75H7.5a.75.75 0 01-.75-.75v-9z', 'title' => 'Gunakan latar belakang polos', 'desc' => 'Latar yang bersih membantu AI mendeteksi gerakan tangan dengan lebih akurat.'],
                        ['icon' => 'M9.75 9.75a.75.75 0 01.75-.75h3a.75.75 0 01.75.75v3a.75.75 0 01-.75.75h-3a.75.75 0 01-.75-.75v-3zM12 5.25a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0V6a.75.75 0 01.75-.75zM12 16.5a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5a.75.75 0 01.75-.75zM18.5 13.5a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75zM3.25 13.5a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5H4a.75.75 0 01-.75-.75zM17.25 5.25a.75.75 0 010 1.06l-1.06 1.06a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 011.06 0zM8.87 16.87a.75.75 0 010 1.06l-1.06 1.06a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 011.06 0z', 'title' => 'Tahan posisi beberapa detik', 'desc' => 'Setelah membentuk gestur, tahan diam agar sistem dapat mengenali huruf dengan benar.'],
                        ['icon' => 'M12 6a.75.75 0 01.75.75v4.5a.75.75 0 01-.75.75H7.5a.75.75 0 010-1.5h3.75V6.75A.75.75 0 0112 6zM12 18a.75.75 0 01-.75-.75v-4.5a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-3.75v3.75a.75.75 0 01-.75.75z', 'title' => 'Jarak tangan dari kamera', 'desc' => 'Idealnya 30–50 cm dari kamera agar detail jari dapat terdeteksi secara optimal.']
                    ];
                @endphp
                @foreach($tips as $index => $tip)
                    <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-3 border border-gray-100 hover:border-pink-200 transition-colors">
                        <div class="w-7 h-7 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-pink-600">{{ $index + 1 }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-gray-800 leading-snug">{{ $tip['title'] }}</p>
                            <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $tip['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-amber-50 border border-amber-200 rounded-xl p-3">
                <div class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/>
                    </svg>
                    <div>
                        <p class="text-xs font-bold text-amber-800 mb-1"> Tips</p>
                        <p class="text-xs text-amber-700 leading-relaxed">
                            Jika gestur tidak terdeteksi, coba perbaiki pencahayaan atau pindahkan tangan sedikit lebih ke depan kamera.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Constants
    const DURASI_AWAL = 30;
    const FASTAPI_URL = "http://127.0.0.1:8000/predict";
    const TARGET_HURUF = "{{ strtoupper($huruf) }}";
    const MODULE = "{{ strtoupper($modul) }}";

    // State variables
    let timeLeft = DURASI_AWAL;
    let timerInterval = null;
    let detectionInterval = null;
    let cameraStream = null;
    let isProcessing = false;
    let sudahDisimpan = false;
    let lastPredictions = [];

    // DOM Elements
    const timerText = document.getElementById('timerText');
    const detectionStatus = document.getElementById('detectionStatus');
    const video = document.getElementById('cameraFeed');
    const canvas = document.getElementById('captureCanvas');
    const timerOverlay = document.getElementById('timerOverlay');
    const successOverlay = document.getElementById('successOverlay');
    const successIcon = document.getElementById('successIcon');

    // Helper Functions
    const getDurasiTerpakai = () => DURASI_AWAL - timeLeft;
    const getMostFrequentPrediction = (predictions) => {
        const counts = {};
        predictions.forEach(p => counts[p] = (counts[p] || 0) + 1);
        return Object.keys(counts).reduce((a, b) => counts[a] > counts[b] ? a : b);
    };

    async function simpanHasilAI(language, huruf, skorAI, prediksiAI, durasiDetik) {
        if (sudahDisimpan) return;
        sudahDisimpan = true;
        try {
            await fetch('/praktik/simpan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ language, huruf, skor_ai: skorAI, prediksi_ai: prediksiAI, duration_seconds: durasiDetik }),
            });
        } catch (err) {
            sudahDisimpan = false;
        }
    }

    function tampilkanSukses(confidence) {
        stopDetection();
        if (timerInterval) clearInterval(timerInterval);
        video.style.filter = 'blur(3px) brightness(0.6)';
        successOverlay.classList.remove('hidden');
        successOverlay.style.display = 'flex';
        document.getElementById('successScore').innerText = `Akurasi: ${(confidence * 100).toFixed(1)}%`;
        setTimeout(() => { successIcon.style.transform = 'scale(1)'; }, 100);
        setTimeout(() => {
            if (cameraStream) {
                cameraStream.getTracks().forEach(t => t.stop());
                cameraStream = null;
            }
        }, 2000);
    }

    function startTimer() {
        if (timerInterval) clearInterval(timerInterval);
        timeLeft = DURASI_AWAL;
        timerText.innerText = timeLeft;
        timerText.style.color = '#C07EB5';

        timerInterval = setInterval(() => {
            timeLeft--;
            timerText.innerText = timeLeft > 0 ? timeLeft : 0;
            timerText.style.color = timeLeft <= 10 ? '#EF4444' : '#C07EB5';

            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                stopDetection();
                detectionStatus.innerText = 'Waktu habis! Klik Ulangi untuk mencoba lagi.';
                detectionStatus.style.color = '#EF4444';
                video.style.filter = 'blur(4px)';
                timerOverlay.classList.remove('hidden');
                timerOverlay.style.display = 'flex';
                const prediksiTerakhir = lastPredictions.length > 0 ? getMostFrequentPrediction(lastPredictions) : null;
                simpanHasilAI(MODULE.toLowerCase(), TARGET_HURUF, 0.0, prediksiTerakhir, DURASI_AWAL);
            }
        }, 1000);
    }

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

        const ctx = canvas.getContext('2d');
        ctx.save();
        ctx.scale(-1, 1);
        ctx.drawImage(video, -canvas.width, 0, canvas.width, canvas.height);
        ctx.restore();

        canvas.toBlob(async function(blob) {
            if (!blob) {
                isProcessing = false;
                return;
            }
            const formData = new FormData();
            formData.append('module', MODULE);
            formData.append('file', blob, 'frame.jpg');

            try {
                const response = await fetch(FASTAPI_URL, { method: 'POST', body: formData });
                const result = await response.json();
                handlePredictionResult(result);
            } catch (error) {
                detectionStatus.innerText = 'Server AI tidak aktif. Pastikan FastAPI menyala.';
                detectionStatus.style.color = '#EF4444';
            }
            isProcessing = false;
        }, 'image/jpeg', 0.8);
    }

    function handlePredictionResult(result) {
        if (!result.success) {
            detectionStatus.innerText = result.message || 'Tangan tidak terdeteksi.';
            detectionStatus.style.color = '#6B7280';
            return;
        }

        const predicted = result.prediction.toUpperCase();
        const confidence = result.confidence;
        const confidencePercent = (confidence * 100).toFixed(1);

        lastPredictions.push(predicted);
        if (lastPredictions.length > 5) lastPredictions.shift();
        const finalPrediction = getMostFrequentPrediction(lastPredictions);

        if (confidence < 0.70) {
            detectionStatus.innerText = `Terdeteksi ${predicted} (${confidencePercent}%) — confidence rendah. Perjelas posisi tangan.`;
            detectionStatus.style.color = '#F59E0B';
            return;
        }

        if (finalPrediction === TARGET_HURUF) {
            detectionStatus.innerText = `✓ Benar! Huruf ${TARGET_HURUF} terdeteksi!`;
            detectionStatus.style.color = '#22C55E';
            simpanHasilAI(MODULE.toLowerCase(), TARGET_HURUF, confidence, predicted, getDurasiTerpakai());
            setTimeout(() => tampilkanSukses(confidence), 600);
        } else {
            detectionStatus.innerText = `Terdeteksi ${finalPrediction} (${confidencePercent}%). Target: ${TARGET_HURUF}`;
            detectionStatus.style.color = '#EF4444';
        }
    }

    // Main Functions
    async function mulaiKamera() {
        document.getElementById('cameraConfirm').classList.add('hidden');
        document.getElementById('cameraArea').classList.remove('hidden');
        successOverlay.classList.add('hidden');
        successIcon.style.transform = 'scale(0)';

        try {
            cameraStream = await navigator.mediaDevices.getUserMedia({
                video: { width: 640, height: 480, facingMode: 'user' },
                audio: false
            });
            video.srcObject = cameraStream;
            document.getElementById('cameraPlaceholder').style.display = 'none';
            detectionStatus.innerText = 'Kamera aktif. Tunjukkan gesture tangan...';
            detectionStatus.style.color = '#6B7280';
            startTimer();
            startDetection();
        } catch (err) {
            document.getElementById('cameraPlaceholder').style.display = 'flex';
            detectionStatus.innerText = 'Izinkan akses kamera untuk mendeteksi isyarat.';
            detectionStatus.style.color = '#EF4444';
        }
    }

    function resetPractice() {
        lastPredictions = [];
        sudahDisimpan = false;
        timerText.innerText = DURASI_AWAL;
        timerText.style.color = '#C07EB5';
        timerOverlay.classList.add('hidden');
        timerOverlay.style.display = 'none';
        mulaiKamera();
    }
</script>
@endpush

@endsection
