@extends('layout.app')

@section('title', 'SignLearn - Profil')

@section('content')

@include('layout.navbar')

<div class="w-full" style="background-color: #FEE6F2;">
    <div class="px-6 py-5 max-w-5xl mx-auto">

        {{-- Notifikasi Session --}}
        @if(session('success'))
        <div id="successMessage" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div id="errorMessage" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

       {{-- ===== PROFIL CARD DENGAN FOTO ===== --}}
<div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-6 mb-6">
    <h2 class="text-lg font-extrabold text-gray-800 mb-4">Foto Profil</h2>

    <div class="flex items-center gap-6 mb-6">
        <div class="relative shrink-0">
            <div class="relative w-28 h-28 rounded-2xl overflow-hidden bg-gradient-to-br from-pink-100 to-purple-100 shadow-lg border-2 border-pink-200">
                @if($user->avatar && file_exists(public_path('assets/avatars/' . $user->avatar)))
                    <img src="{{ asset('assets/avatars/' . $user->avatar) }}"
                         alt="Profile"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="text-6xl font-bold text-pink-300">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    </div>
                @endif
            </div>
            <button onclick="document.getElementById('avatarInput').click()"
                    class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full bg-pink-600 text-white flex items-center justify-center shadow-lg hover:bg-pink-700 hover:scale-105 transition-all">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4">
                    <path d="M3 17.25V21h3.75l11.06-11.06-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                </svg>
            </button>
            <form id="avatarForm" action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" class="hidden">
                @csrf
                <input type="file"
                       id="avatarInput"
                       name="avatar"
                       accept="image/*"
                       onchange="document.getElementById('avatarForm').submit()">
            </form>
        </div>
        <div>
            <p class="text-2xl font-black text-gray-900">{{ $user->name }}</p>
            <p class="text-sm text-gray-500">{{ $user->email }}</p>
            <button onclick="document.getElementById('avatarInput').click()"
                    class="text-sm font-semibold text-pink-600 hover:text-pink-700 transition-colors mt-1">
                Ganti Foto
            </button>
        </div>
    </div>
</div>

        {{-- ===== INFORMASI AKUN ===== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-6 mb-6">
            <h2 class="text-lg font-extrabold text-gray-800 mb-4">Informasi Akun</h2>

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-xs text-gray-500 mb-1 ml-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap"
                        value="{{ old('nama_lengkap', $user->name) }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-300 transition @error('nama_lengkap') border-red-500 @enderror" />
                    @error('nama_lengkap')
                        <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Username --}}
                <div>
                    <label class="block text-xs text-gray-500 mb-1 ml-1">Username</label>
                    <input type="text" name="username"
                        value="{{ old('username', $user->username) }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-300 transition @error('username') border-red-500 @enderror" />
                    @error('username')
                        <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs text-gray-500 mb-1 ml-1">Email</label>
                    <input type="email" name="email"
                        value="{{ old('email', $user->email) }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-300 transition @error('email') border-red-500 @enderror" />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- No. Telepon --}}
                <div>
                    <label class="block text-xs text-gray-500 mb-1 ml-1">No. Telepon</label>
                    <input type="tel" name="nomor_telepon"
                        value="{{ old('nomor_telepon', $user->phone) }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-300 transition @error('nomor_telepon') border-red-500 @enderror" />
                    @error('nomor_telepon')
                        <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>



                {{-- Ganti Password --}}
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-xs text-gray-500 ml-1">Password Baru (Opsional)</label>
                        <button type="button" onclick="togglePassword()"
                            class="text-xs text-pink-500 hover:text-pink-600 font-semibold">
                            Ganti Password
                        </button>
                    </div>

                    <div id="passwordSection" style="display: none;">
                        <input type="password" name="password" id="password"
                            placeholder="Masukkan password baru (minimal 8 karakter)"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-300 transition mb-2" />
                        @error('password')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror

                        <input type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="Konfirmasi password baru"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-300 transition" />
                    </div>
                </div>

                {{-- Tombol Simpan --}}
                <div class="pt-3">
                    <button type="submit"
                        class="px-6 py-2 rounded-xl text-white text-sm font-semibold transition hover:opacity-90"
                        style="background-color: #D96FAD;">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

        {{-- ===== STATISTIK ===== --}}
        <div class="grid grid-cols-2 gap-4 mb-6">

        <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-5 text-center hover:shadow-md transition">
            <p class="text-sm text-gray-500 font-medium">Total Aktivitas</p>
            <p class="text-4xl font-extrabold text-gray-800 mt-1">{{ $totalLatihan }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $statPerBahasa['bisindo']['total_kuis'] + $statPerBahasa['sibi']['total_kuis'] }} kuis · {{ $statPerBahasa['bisindo']['total_praktik'] + $statPerBahasa['sibi']['total_praktik'] }} praktik</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-5 text-center hover:shadow-md transition">
            <p class="text-sm text-gray-500 font-medium">Praktik Terakhir</p>

            @if($hurufTerakhir !== '-')
            <a href="{{ route('pembelajaran.index') }}"
                class="text-4xl font-extrabold text-pink-500 mt-1 block hover:text-pink-600 transition">
                {{ $hurufTerakhir }}
            </a>
            <p class="text-xs text-gray-400 mt-1">{{ $bahasaTerakhir }}</p>
            @if($skorTerakhir !== null)
                <p class="text-xs font-bold mt-0.5
                        {{ $skorTerakhir >= 80 ? 'text-green-500' : 'text-yellow-500' }}">
                Skor: {{ $skorTerakhir }}%
                </p>
            @endif
            @if($tanggalTerakhir)
                <p class="text-[0.68rem] text-gray-300 mt-0.5">{{ $tanggalTerakhir }}</p>
            @endif
            @else
            <p class="text-4xl font-extrabold text-gray-300 mt-1">-</p>
            <a href="{{ route('pembelajaran.index') }}"
                class="text-xs text-pink-400 mt-1 block hover:underline">
                Mulai praktik →
            </a>
            @endif
        </div>

        </div>
        {{-- ===== STATISTIK PER BAHASA ===== --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">

            {{-- BISINDO --}}
            <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-extrabold text-gray-800 text-sm">BISINDO</h3>
                    <a href="{{ route('histori') }}" class="text-xs text-pink-500 font-semibold hover:underline">
                        Lihat Histori →
                    </a>
                </div>
                <div class="grid grid-cols-2 gap-2 text-center">
                    <div class="bg-pink-50 rounded-xl py-2 px-1">
                        <p class="text-xl font-black text-pink-600">{{ $statPerBahasa['bisindo']['total_kuis'] }}</p>
                        <p class="text-[0.65rem] text-gray-400 font-medium mt-0.5">Total Kuis</p>
                    </div>
                    <div class="bg-pink-50 rounded-xl py-2 px-1">
                        <p class="text-xl font-black text-pink-600">{{ $statPerBahasa['bisindo']['total_praktik'] }}</p>
                        <p class="text-[0.65rem] text-gray-400 font-medium mt-0.5">Total Praktik</p>
                    </div>
                    <div class="bg-pink-50 rounded-xl py-2 px-1">
                        <p class="text-xl font-black text-pink-600">{{ $statPerBahasa['bisindo']['rata_skor_kuis'] }}%</p>
                        <p class="text-[0.65rem] text-gray-400 font-medium mt-0.5">Rata Kuis</p>
                    </div>
                    <div class="bg-pink-50 rounded-xl py-2 px-1">
                        <p class="text-xl font-black text-pink-600">{{ $statPerBahasa['bisindo']['skor_terbaik'] }}%</p>
                        <p class="text-[0.65rem] text-gray-400 font-medium mt-0.5">Skor Terbaik</p>
                    </div>
                </div>
            </div>

            {{-- SIBI --}}
            <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-extrabold text-gray-800 text-sm">SIBI</h3>
                    <a href="{{ route('histori') }}" class="text-xs text-pink-500 font-semibold hover:underline">
                        Lihat Histori →
                    </a>
                </div>
                <div class="grid grid-cols-2 gap-2 text-center">
                    <div class="bg-blue-50 rounded-xl py-2 px-1">
                        <p class="text-xl font-black text-blue-500">{{ $statPerBahasa['sibi']['total_kuis'] }}</p>
                        <p class="text-[0.65rem] text-gray-400 font-medium mt-0.5">Total Kuis</p>
                    </div>
                    <div class="bg-blue-50 rounded-xl py-2 px-1">
                        <p class="text-xl font-black text-blue-500">{{ $statPerBahasa['sibi']['total_praktik'] }}</p>
                        <p class="text-[0.65rem] text-gray-400 font-medium mt-0.5">Total Praktik</p>
                    </div>
                    <div class="bg-blue-50 rounded-xl py-2 px-1">
                        <p class="text-xl font-black text-blue-500">{{ $statPerBahasa['sibi']['rata_skor_kuis'] }}%</p>
                        <p class="text-[0.65rem] text-gray-400 font-medium mt-0.5">Rata Kuis</p>
                    </div>
                    <div class="bg-blue-50 rounded-xl py-2 px-1">
                        <p class="text-xl font-black text-blue-500">{{ $statPerBahasa['sibi']['skor_terbaik'] }}%</p>
                        <p class="text-[0.65rem] text-gray-400 font-medium mt-0.5">Skor Terbaik</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    // Toggle password section
    function togglePassword() {
        const section = document.getElementById('passwordSection');
        if (section.style.display === 'none' || section.style.display === '') {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
            document.getElementById('password').value = '';
            document.getElementById('password_confirmation').value = '';
        }
    }

    // Auto hide messages after 3 seconds
    setTimeout(function() {
        const successMsg = document.getElementById('successMessage');
        const errorMsg = document.getElementById('errorMessage');
        if (successMsg) successMsg.style.display = 'none';
        if (errorMsg) errorMsg.style.display = 'none';
    }, 3000);
</script>

@include('layout.footer')
@endsection
