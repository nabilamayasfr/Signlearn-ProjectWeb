@extends('layout.admin')

@section('title', 'SignLearn - Dashboard Admin')

@section('content')

{{-- Header --}}
<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-gray-800">Dashboard</h1>
    <p class="text-gray-400 text-sm mt-1">Selamat datang di panel admin SignLearn! Kelola pengguna, modul, dan kuis dengan mudah.</p>
</div>

{{-- Statistik Cards --}}
<div class="grid grid-cols-4 gap-4 mb-8">

    {{-- Total Pengguna --}}
    <div class="rounded-2xl p-5 bg-[#EDD5F7]">
        <div class="flex items-center gap-2 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#7B2FBE]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-4.13a4 4 0 10-8 0 4 4 0 008 0z"/>
            </svg>
            <span class="text-3xl font-extrabold text-gray-800" id="dash-total-user">0</span>
        </div>
        <p class="text-sm font-bold text-[#7B2FBE]">Total Pengguna</p>
    </div>

    {{-- Total Modul --}}
    <div class="rounded-2xl p-5 bg-[#FCE7F3]">
        <div class="flex items-center gap-2 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#C82D85]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332-.477-4.5-1.253"/>
            </svg>
            <span class="text-3xl font-extrabold text-gray-800" id="dash-total-modul">0</span>
        </div>
        <p class="text-sm font-bold text-[#C82D85]">Total Modul</p>
    </div>

    {{-- Total Soal Kuis --}}
    <div class="rounded-2xl p-5 bg-[#E0E7FF]">
        <div class="flex items-center gap-2 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <span class="text-3xl font-extrabold text-gray-800" id="dash-total-soal">0</span>
        </div>
        <p class="text-sm font-bold text-indigo-500">Total Soal Kuis</p>
    </div>

    {{-- Total Level --}}
    <div class="rounded-2xl p-5 bg-[#FEF3C7]">
        <div class="flex items-center gap-2 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            <span class="text-3xl font-extrabold text-gray-800" id="dash-total-level">0</span>
        </div>
        <p class="text-sm font-bold text-yellow-600">Total Level Kuis</p>
    </div>

</div>

{{-- Aktivitas Terbaru --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
    <h2 class="text-lg font-extrabold text-gray-800 mb-4"> Ringkasan Aktivitas</h2>

    <div class="grid grid-cols-2 gap-6">
        {{-- Pengguna Terbaru --}}
        <div>
            <h3 class="text-sm font-bold text-gray-500 mb-3"> Pengguna Terbaru</h3>
            <div class="space-y-2" id="dash-user-terbaru">
                <p class="text-sm text-gray-400">Memuat data...</p>
            </div>
        </div>

        {{-- Modul Terbaru --}}
        <div>
            <h3 class="text-sm font-bold text-gray-500 mb-3"> Modul Terbaru</h3>
            <div class="space-y-2" id="dash-modul-terbaru">
                <p class="text-sm text-gray-400">Memuat data...</p>
            </div>
        </div>
    </div>
</div>

{{-- Statistik Per Modul & Per Level --}}
<div class="grid grid-cols-2 gap-6">
    {{-- Distribusi Modul --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-sm font-bold text-gray-500 mb-4"> Distribusi Modul</h3>
        <div class="flex items-center gap-4">
            <div class="flex-1">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-600">BISINDO</span>
                    <span class="text-sm font-bold text-[#C82D85]" id="dash-bisindo-count">0</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2.5">
                    <div class="bg-[#C82D85] h-2.5 rounded-full" id="dash-bisindo-bar" style="width: 0%"></div>
                </div>
            </div>
            <div class="flex-1">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-600">SIBI</span>
                    <span class="text-sm font-bold text-[#7B2FBE]" id="dash-sibi-count">0</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2.5">
                    <div class="bg-[#7B2FBE] h-2.5 rounded-full" id="dash-sibi-bar" style="width: 0%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Soal per Level --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-sm font-bold text-gray-500 mb-4"> Distribusi Soal per Level</h3>
        <div class="space-y-3">
            <div>
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm text-gray-600">Pemula</span>
                    <span class="text-sm font-bold text-blue-600" id="dash-level-pemula">0</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" id="dash-level-pemula-bar" style="width: 0%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm text-gray-600">Menengah</span>
                    <span class="text-sm font-bold text-green-600" id="dash-level-menengah">0</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" id="dash-level-menengah-bar" style="width: 0%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm text-gray-600">Mahir</span>
                    <span class="text-sm font-bold text-purple-600" id="dash-level-mahir">0</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-purple-500 h-2 rounded-full" id="dash-level-mahir-bar" style="width: 0%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// ── LOAD DASHBOARD DATA ──────────────────────────
async function loadDashboard() {
    try {
        const res = await fetch('/admin/dashboard/data');
        const data = await res.json();

        if (!res.ok) throw new Error(data.message || 'Gagal memuat data');

        // Total Pengguna
        document.getElementById('dash-total-user').innerText = data.total_users || 0;

        // Total Modul
        document.getElementById('dash-total-modul').innerText = data.total_moduls || 0;

        // Total Soal
        document.getElementById('dash-total-soal').innerText = data.total_soal || 0;

        // Total Level
        document.getElementById('dash-total-level').innerText = data.total_levels || 0;

        // Distribusi Modul
        document.getElementById('dash-bisindo-count').innerText = data.bisindo_count || 0;
        document.getElementById('dash-sibi-count').innerText = data.sibi_count || 0;

        const totalModul = (data.bisindo_count || 0) + (data.sibi_count || 0);
        if (totalModul > 0) {
            const bisindoPct = ((data.bisindo_count || 0) / totalModul) * 100;
            const sibiPct = ((data.sibi_count || 0) / totalModul) * 100;
            document.getElementById('dash-bisindo-bar').style.width = bisindoPct + '%';
            document.getElementById('dash-sibi-bar').style.width = sibiPct + '%';
        }

        // Distribusi Soal per Level
        const levelStats = data.level_stats || {};
        const totalSoal = data.total_soal || 1;

        document.getElementById('dash-level-pemula').innerText = levelStats.pemula || 0;
        document.getElementById('dash-level-menengah').innerText = levelStats.menengah || 0;
        document.getElementById('dash-level-mahir').innerText = levelStats.mahir || 0;

        document.getElementById('dash-level-pemula-bar').style.width = ((levelStats.pemula || 0) / totalSoal * 100) + '%';
        document.getElementById('dash-level-menengah-bar').style.width = ((levelStats.menengah || 0) / totalSoal * 100) + '%';
        document.getElementById('dash-level-mahir-bar').style.width = ((levelStats.mahir || 0) / totalSoal * 100) + '%';

        // Pengguna Terbaru
        const userContainer = document.getElementById('dash-user-terbaru');
        if (data.recent_users && data.recent_users.length > 0) {
            userContainer.innerHTML = data.recent_users.map(user => `
                <div class="flex items-center justify-between text-sm border-b border-gray-50 pb-2">
                    <span class="font-medium text-gray-700">${user.name}</span>
                    <span class="text-xs text-gray-400">${user.email}</span>
                </div>
            `).join('');
        } else {
            userContainer.innerHTML = '<p class="text-sm text-gray-400">Belum ada pengguna.</p>';
        }

        // Modul Terbaru
        const modulContainer = document.getElementById('dash-modul-terbaru');
        if (data.recent_moduls && data.recent_moduls.length > 0) {
            modulContainer.innerHTML = data.recent_moduls.map(modul => `
                <div class="flex items-center justify-between text-sm border-b border-gray-50 pb-2">
                    <span class="font-medium text-gray-700">Huruf ${modul.huruf}</span>
                    <span class="text-xs px-2 py-0.5 rounded-full ${modul.modul === 'BISINDO' ? 'bg-pink-100 text-pink-600' : 'bg-indigo-100 text-indigo-600'}">${modul.modul}</span>
                </div>
            `).join('');
        } else {
            modulContainer.innerHTML = '<p class="text-sm text-gray-400">Belum ada modul.</p>';
        }

    } catch (err) {
        console.error('Gagal load dashboard:', err);
    }
}

// ── INIT ─────────────────────────────────────────
document.addEventListener('DOMContentLoaded', loadDashboard);
</script>
@endpush

@endsection
