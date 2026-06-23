@extends('layout.app')

@section('title', 'SignLearn - Pembelajaran')

@section('content')

@include('layout.navbar')

{{-- ===== KONTEN UTAMA ===== --}}
<div class="w-full" style="background-color: #FEE6F2;">
    <div class="px-6 py-5 max-w-6xl mx-auto">

        {{-- JUDUL --}}
        <div class="flex justify-between items-start mb-5">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-[#492F48] leading-tight">
                    Modul Pembelajaran
                </h1>
                <p class="text-[#5C3D5A] text-sm mt-1 font-medium">Pilih modul dan pelajari bahasa isyarat A-Z</p>
            </div>
        </div>

        {{-- PROGRESS BELAJAR --}}
        <div class="bg-white rounded-2xl shadow-sm p-5 mb-6 border border-pink-100">
            <h3 class="font-extrabold text-[#2D1A2E] mb-1 text-base">Kemajuan Belajar</h3>
            <p class="text-[#5C3D5A] text-sm mb-3 font-medium">
                Kamu sudah menguasai
                <span id="progressCountText" class="font-bold text-[#2D1A2E]">0/26 huruf (0%)</span>
            </p>
            <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                <div id="progressFillBar"
                     class="h-3 rounded-full transition-all duration-500"
                     style="width: 0%; background: linear-gradient(90deg, #F472B6, #DB2777);"></div>
            </div>
            <p class="text-xs text-[#A882A6] mt-1 font-medium" id="progressLabel">(0% selesai)</p>
        </div>

        {{-- PILIH MODUL --}}
        <h2 class="text-lg font-extrabold text-[#2D1A2E] mb-3">Pilih Modul</h2>
        <div class="grid grid-cols-2 gap-4 mb-6">

            {{-- BISINDO --}}
            <div id="moduleBisindo"
                 onclick="setActiveModule('BISINDO')"
                 class="bg-white rounded-2xl shadow-sm border-2 border-pink-400 p-4 cursor-pointer transition-all duration-300">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-base font-extrabold text-[#2D1A2E]">BISINDO</h3>
                        <p class="text-[#5C3D5A] text-xs font-medium">Bahasa isyarat Indonesia</p>
                    </div>
                    <button id="btnBisindo"
                            onclick="event.stopPropagation(); setActiveModule('BISINDO')"
                            class="text-xs font-bold px-4 py-2 rounded-xl transition"
                            style="background-color: #D96FAD; color: white;">
                        Aktif
                    </button>
                </div>
            </div>

            {{-- SIBI --}}
            <div id="moduleSibi"
                 onclick="setActiveModule('SIBI')"
                 class="bg-white rounded-2xl shadow-sm border-2 border-gray-200 p-4 cursor-pointer transition-all duration-300">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-base font-extrabold text-[#2D1A2E]">SIBI</h3>
                        <p class="text-[#5C3D5A] text-xs font-medium">Sistem isyarat Bahasa Indonesia</p>
                    </div>
                    <button id="btnSibi"
                            onclick="event.stopPropagation(); setActiveModule('SIBI')"
                            class="text-xs font-bold px-4 py-2 rounded-xl transition bg-gray-100 text-gray-400">
                        Mulai
                    </button>
                </div>
            </div>
        </div>

        {{-- HURUF A-Z --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-pink-100 mb-8">
            <div class="flex items-center gap-2 mb-4">
                <h3 class="text-lg font-extrabold text-[#2D1A2E]">Huruf A-Z</h3>
                <span id="activeModuleBadge"
                      class="text-xs font-bold px-3 py-1 rounded-full text-white"
                      style="background-color: #D96FAD;">BISINDO</span>
            </div>
            <div id="gridLoading" class="text-center py-6 text-[#5C3D5A] text-sm font-medium">Memuat data...</div>
            <div class="grid grid-cols-8 gap-2" id="alphabetGrid"></div>
        </div>
    </div>
</div>

{{-- MODAL --}}
<div id="letterModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[9999]"
     style="display: none;">
    <div class="bg-white rounded-3xl max-w-md w-full mx-6 p-6 shadow-2xl relative my-8">
        <button id="closeModalBtn"
                class="absolute top-4 right-5 text-gray-400 hover:text-gray-600 text-3xl leading-none z-10">
            &times;
        </button>
        <div class="text-center mb-2">
            <h3 class="text-2xl font-extrabold text-[#2D1A2E]">
                Belajar Huruf <span id="modalLetter" class="text-pink-500">A</span>
            </h3>
        </div>
        <div class="flex justify-center my-5">
            <div class="bg-[#FEF2F8] rounded-2xl p-6 border border-pink-100 w-full flex flex-col items-center">
                <div class="text-7xl font-black text-pink-400 mb-2" id="modalLetterBig">A</div>
                <p class="text-[#5C3D5A] text-sm mt-4 text-center font-medium" id="modalDescription"></p>
            </div>
        </div>
        <div class="flex flex-col gap-3 mt-2">
            <button id="viewModuleBtn"
                    class="w-full py-3 rounded-xl font-bold text-pink-600 bg-pink-50 border border-pink-200 hover:bg-pink-100 transition flex items-center justify-center gap-2">
                Lihat Modul
            </button>
            <button id="practiceNowBtn"
                    class="w-full py-3 rounded-xl font-bold text-white bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 transition shadow-md flex items-center justify-center gap-2">
                Praktik Langsung
            </button>
            <button id="markMasteredModalBtn"
                    class="w-full py-3 rounded-xl font-bold border-2 transition flex items-center justify-center gap-2 border-green-400 text-green-700 bg-green-50 hover:bg-green-100">
                ✓ Sudah Dikuasai
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const allLetters = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    let currentModule  = 'BISINDO';
    let masteredLetters = [];
    let selectedLetter  = null;
    let isSaving        = false;

    // ─── LOAD PROGRESS DARI DATABASE ───────────────────────────────────────────
    async function loadProgress() {
        document.getElementById('gridLoading').style.display = 'block';
        document.getElementById('alphabetGrid').innerHTML    = '';

        try {
            const res  = await fetch(`/pembelajaran/progress?module=${currentModule}`, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            masteredLetters = Array.isArray(data.mastered) ? data.mastered : [];
        } catch (err) {
            console.warn('Gagal load progress dari server, fallback ke localStorage:', err);
            const stored    = localStorage.getItem(`signlearn_mastered_${currentModule}`);
            masteredLetters = stored ? JSON.parse(stored) : [];
        }

        document.getElementById('gridLoading').style.display = 'none';
        updateProgressUI();
    }

    // ─── UPDATE UI PROGRESS BAR ─────────────────────────────────────────────────
    function updateProgressUI() {
        const count   = masteredLetters.length;
        const percent = Math.floor((count / 26) * 100);
        document.getElementById('progressCountText').innerHTML = `${count}/26 huruf (${percent}%)`;
        document.getElementById('progressFillBar').style.width = `${percent}%`;
        document.getElementById('progressLabel').innerHTML     = `(${percent}% selesai)`;
        renderAlphabetGrid();
    }

    // ─── SIMPAN KE DATABASE ─────────────────────────────────────────────────────
    async function saveMastered(letter) {
        if (isSaving) return;
        isSaving = true;

        try {
            const res = await fetch('/pembelajaran/progress/simpan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').content,
                    'Accept'       : 'application/json',
                },
                body: JSON.stringify({
                    module : currentModule,
                    huruf  : letter,
                }),
            });

            const data = await res.json();

            if (data.success) {
                masteredLetters = Array.isArray(data.mastered) ? data.mastered : masteredLetters;
            } else {
                throw new Error(data.message ?? 'Gagal menyimpan');
            }
        } catch (err) {
            console.warn('Gagal simpan ke server, fallback localStorage:', err);
            if (!masteredLetters.includes(letter)) masteredLetters.push(letter);
            localStorage.setItem(`signlearn_mastered_${currentModule}`, JSON.stringify(masteredLetters));
        } finally {
            isSaving = false;
        }

        updateProgressUI();
    }

    // ─── RENDER GRID HURUF A-Z ──────────────────────────────────────────────────
    function renderAlphabetGrid() {
        const grid = document.getElementById('alphabetGrid');
        if (!grid) return;
        grid.innerHTML = '';

        allLetters.forEach(letter => {
            const mastered = masteredLetters.includes(letter);
            const div      = document.createElement('div');

            div.className = `relative flex flex-col items-center justify-center py-3 rounded-xl cursor-pointer border-2 transition-all duration-200 select-none`;

            if (mastered) {
                div.style.background = 'linear-gradient(135deg, #F9A8D4, #EC4899)';
                div.style.borderColor = '#F472B6';
                div.innerHTML = `
                    <span class="text-base font-extrabold text-white">${letter}</span>
                    <span class="absolute top-1 right-1.5 text-white text-xs font-bold">✓</span>
                `;
            } else {
                div.style.background  = '#FFFFFF';
                div.style.borderColor = '#E5E7EB';
                div.innerHTML = `
                    <span class="text-base font-extrabold text-[#2D1A2E]">${letter}</span>
                `;
                div.addEventListener('mouseenter', () => {
                    if (!masteredLetters.includes(letter)) div.style.borderColor = '#F9A8D4';
                });
                div.addEventListener('mouseleave', () => {
                    if (!masteredLetters.includes(letter)) div.style.borderColor = '#E5E7EB';
                });
            }

            div.addEventListener('click', () => showModal(letter));
            grid.appendChild(div);
        });
    }

    // ─── MODAL ──────────────────────────────────────────────────────────────────
    function showModal(letter) {
        selectedLetter = letter;
        const isMastered = masteredLetters.includes(letter);

        document.getElementById('modalLetter').innerText    = letter;
        document.getElementById('modalLetterBig').innerText = letter;
        document.getElementById('modalDescription').innerText =
            `Pelajari bahasa isyarat untuk huruf ${letter} dalam modul ${currentModule}`;

        const markBtn = document.getElementById('markMasteredModalBtn');
        if (isMastered) {
            markBtn.innerHTML    = '✓ Sudah Dikuasai';
            markBtn.disabled     = true;
            markBtn.style.opacity = '0.5';
            markBtn.style.cursor  = 'not-allowed';
            markBtn.className     = 'w-full py-3 rounded-xl font-bold border-2 transition flex items-center justify-center gap-2 border-green-300 text-green-500 bg-green-50 cursor-not-allowed';
        } else {
            markBtn.innerHTML    = '✓ Tandai Sudah Dikuasai';
            markBtn.disabled     = false;
            markBtn.style.opacity = '1';
            markBtn.style.cursor  = 'pointer';
            markBtn.className     = 'w-full py-3 rounded-xl font-bold border-2 transition flex items-center justify-center gap-2 border-green-400 text-green-700 bg-green-50 hover:bg-green-100';
        }

        document.getElementById('letterModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('letterModal').style.display = 'none';
        selectedLetter = null;
    }

    // ─── TOMBOL MODAL ───────────────────────────────────────────────────────────
    document.getElementById('viewModuleBtn').onclick = function () {
        if (selectedLetter) {
            window.location.href = `/pembelajaran/${currentModule.toLowerCase()}/${selectedLetter.toLowerCase()}`;
        }
    };

    document.getElementById('practiceNowBtn').onclick = function () {
        if (selectedLetter) {
            window.location.href = `/praktik/${currentModule.toLowerCase()}/${selectedLetter.toLowerCase()}`;
        }
    };

    async function markMasteredFromModal() {
        if (!selectedLetter) return;
        if (masteredLetters.includes(selectedLetter)) {
            showToast(`Huruf ${selectedLetter} sudah dikuasai sebelumnya!`, 'info');
            closeModal();
            return;
        }

        const letter = selectedLetter;
        closeModal();

        showToast(`Menyimpan huruf ${letter}...`, 'info');
        await saveMastered(letter);
        showToast(`✓ Huruf ${letter} berhasil dikuasai!`, 'success');
    }

    // ─── TOAST NOTIFIKASI ───────────────────────────────────────────────────────
    function showToast(message, type = 'success') {
        document.querySelectorAll('.signlearn-toast').forEach(t => t.remove());

        const toast = document.createElement('div');
        toast.className = 'signlearn-toast fixed bottom-5 left-1/2 transform -translate-x-1/2 px-5 py-2 rounded-full shadow-lg text-sm z-50 text-white transition-opacity duration-300';
        toast.style.backgroundColor =
            type === 'success' ? '#10B981' :
            type === 'info'    ? '#6366F1' : '#EF4444';
        toast.innerText = message;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 2000);
    }

    // ─── SWITCH MODUL ───────────────────────────────────────────────────────────
    function setActiveModule(module) {
        currentModule = module;

        const bisindoCard = document.getElementById('moduleBisindo');
        const sibiCard    = document.getElementById('moduleSibi');
        const btnBisindo  = document.getElementById('btnBisindo');
        const btnSibi     = document.getElementById('btnSibi');
        const badge       = document.getElementById('activeModuleBadge');

        if (module === 'BISINDO') {
            bisindoCard.style.borderColor = '#F472B6';
            sibiCard.style.borderColor    = '#E5E7EB';
            btnBisindo.innerText          = 'Aktif';
            btnBisindo.style.cssText      = 'background-color:#D96FAD; color:white;';
            btnSibi.innerText             = 'Mulai';
            btnSibi.style.cssText         = '';
            btnSibi.className             = 'text-xs font-bold px-4 py-2 rounded-xl transition bg-gray-100 text-gray-400';
        } else {
            sibiCard.style.borderColor    = '#F472B6';
            bisindoCard.style.borderColor = '#E5E7EB';
            btnSibi.innerText             = 'Aktif';
            btnSibi.style.cssText         = 'background-color:#D96FAD; color:white;';
            btnBisindo.innerText          = 'Mulai';
            btnBisindo.style.cssText      = '';
            btnBisindo.className          = 'text-xs font-bold px-4 py-2 rounded-xl transition bg-gray-100 text-gray-400';
        }

        badge.innerText = module;
        loadProgress();
    }

    // ─── HELPER: Simpan hasil praktik AI ────────────────────────────────────────
    async function simpanHasilAI(language, huruf, skorAI, prediksiAI) {
        try {
            const res = await fetch('/praktik/simpan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    language    : language,
                    huruf       : huruf,
                    skor_ai     : skorAI,
                    prediksi_ai : prediksiAI,
                }),
            });
            const data = await res.json();
            console.log('Hasil tersimpan:', data);
            return data;
        } catch (err) {
            console.warn('Gagal menyimpan hasil praktik:', err);
            return null;
        }
    }

    // ─── EVENT BINDINGS ─────────────────────────────────────────────────────────
    document.getElementById('closeModalBtn').onclick        = closeModal;
    document.getElementById('markMasteredModalBtn').onclick = markMasteredFromModal;
    document.getElementById('letterModal').onclick          = (e) => {
        if (e.target === document.getElementById('letterModal')) closeModal();
    };

    // ─── INIT ───────────────────────────────────────────────────────────────────
    setActiveModule('BISINDO');
</script>
@endpush

@include('layout.footer')
@endsection
