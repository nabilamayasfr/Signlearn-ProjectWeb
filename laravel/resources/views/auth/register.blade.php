@extends('layout.app')

@section('title', 'SignLearn - Daftar Akun')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
    .register-page * {
        font-family: 'Poppins', sans-serif;
    }
    .register-page input {
        font-family: 'Poppins', sans-serif;
    }
    /* Sembunyikan ikon mata bawaan browser pada input password */
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear,
    input[type="password"]::-webkit-contacts-auto-fill-button,
    input[type="password"]::-webkit-credentials-auto-fill-button {
        display: none !important;
        visibility: hidden;
        pointer-events: none;
    }
</style>
@endpush

@section('content')

<div class="register-page flex min-h-screen">

    {{-- ===== KIRI: Branding panel dengan background pink ===== --}}
    <div class="w-1/2 min-h-screen flex flex-col justify-center px-12 py-10"
        style="background: linear-gradient(160deg, #F9C5E2 0%, #C82D85 55%, #951651 100%);">

        <div>
            {{-- Badge --}}
            <div class="inline-flex items-center gap-[7px] bg-white/18 border border-white/35 rounded-full px-4 py-[6px] text-white text-[0.65rem] font-bold tracking-[1.5px] uppercase mb-5 w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-[13px] h-[13px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                </svg>
                Belajar Bahasa Isyarat Mandiri
            </div>

            <h2 class="font-black text-white mb-5 text-[3rem] leading-[1.15]">
                Kuasai Bahasa<br>Isyarat dengan<br>Teknologi AI
            </h2>

            <p class="text-white leading-relaxed max-w-sm text-[0.92rem] opacity-85">
                Platform interaktif berbasis AI untuk mempelajari Bahasa Isyarat kapan saja dan di mana saja.
            </p>

            {{-- Stats --}}
            <div class="flex items-center gap-8 pt-8 mt-8 border-t border-white/30">
                <div>
                    <p class="text-white font-black text-[2rem] leading-none">26</p>
                    <p class="font-semibold tracking-widest uppercase text-[0.65rem] text-white/75">BISINDO</p>
                </div>
                <div class="w-px h-10 bg-white/35"></div>
                <div>
                    <p class="text-white font-black text-[2rem] leading-none">26</p>
                    <p class="font-semibold tracking-widest uppercase text-[0.65rem] text-white/75">SIBI</p>
                </div>
            </div>
        </div>

    </div>

    {{-- ===== KANAN: Form ===== --}}
    <div class="w-1/2 min-h-screen flex flex-col items-center justify-center py-12 px-8"
        style="background: linear-gradient(180deg, #ffffff 60%, #FEE6F2 100%);">

        <div class="w-full max-w-sm">

            {{-- Tulisan --}}
            <div class="mb-6">
                <h1 class="font-extrabold text-gray-800 text-[1.9rem] leading-tight">
                    Daftar Ke <span class="text-[#C82D85]">SIGNLEARN</span>
                </h1>
                <p class="text-gray-500 text-[0.85rem] mt-1">
                    Belajar Bahasa Isyarat dengan AI Secara Mandiri
                </p>
            </div>

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-2 mb-4">
                    <p class="text-red-500 text-xs text-center">{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="space-y-3">
                @csrf

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block font-medium mb-1.5 text-[0.75rem] text-gray-500">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                        class="w-full rounded-2xl px-4 py-3 bg-gray-100 border-0 focus:outline-none focus:ring-2 focus:ring-[#C82D85] transition text-[0.875rem] @error('nama_lengkap') ring-2 ring-red-400 @enderror" />
                    @error('nama_lengkap')
                        <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama Pengguna --}}
                <div>
                    <label class="block font-medium mb-1.5 text-[0.75rem] text-gray-500">Nama Pengguna</label>
                    <input type="text" name="username" value="{{ old('username') }}"
                        class="w-full rounded-2xl px-4 py-3 bg-gray-100 border-0 focus:outline-none focus:ring-2 focus:ring-[#C82D85] transition text-[0.875rem] @error('username') ring-2 ring-red-400 @enderror" />
                    @error('username')
                        <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block font-medium mb-1.5 text-[0.75rem] text-gray-500">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full rounded-2xl px-4 py-3 bg-gray-100 border-0 focus:outline-none focus:ring-2 focus:ring-[#C82D85] transition text-[0.875rem] @error('email') ring-2 ring-red-400 @enderror" />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kata Sandi & Konfirmasi --}}
                <div class="flex gap-3">
                    <div class="w-1/2">
                        <label class="block font-medium mb-1.5 text-[0.75rem] text-gray-500">Kata Sandi</label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                class="w-full rounded-2xl px-4 py-3 bg-gray-100 border-0 focus:outline-none focus:ring-2 focus:ring-[#C82D85] transition pr-10 text-[0.875rem] @error('password') ring-2 ring-red-400 @enderror" />
                            <button type="button" id="togglePassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeOffIcon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-1/2">
                        <label class="block font-medium mb-1.5 text-[0.75rem] text-gray-500">Konfirmasi</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full rounded-2xl px-4 py-3 bg-gray-100 border-0 focus:outline-none focus:ring-2 focus:ring-[#C82D85] transition pr-10 text-[0.875rem]" />
                            <button type="button" id="toggleConfirmPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                                <svg id="eyeIconConfirm" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeOffIconConfirm" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Nomor Telepon --}}
                <div>
                    <label class="block font-medium mb-1.5 text-[0.75rem] text-gray-500">Nomor Telepon</label>
                    <input type="tel" name="nomor_telepon" value="{{ old('nomor_telepon') }}"
                        class="w-full rounded-2xl px-4 py-3 bg-gray-100 border-0 focus:outline-none focus:ring-2 focus:ring-[#C82D85] transition text-[0.875rem] @error('nomor_telepon') ring-2 ring-red-400 @enderror" />
                    @error('nomor_telepon')
                        <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Daftar --}}
                <button type="submit" class="w-full px-[26px] py-[11px] rounded-[12px] bg-[#C82D85] text-white shadow-[0_8px_24px_rgba(200,45,133,0.35)] hover:bg-[#951651] transition font-bold mt-2">
                    Daftar
                </button>

                <p class="text-center text-[0.78rem] text-gray-500 pt-1">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-bold hover:underline text-gray-700">Masuk</a>
                </p>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Toggle Password
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeOffIcon = document.getElementById('eyeOffIcon');

    if (togglePassword) {
        togglePassword.addEventListener('click', function () {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            eyeIcon.classList.toggle('hidden', isHidden);
            eyeOffIcon.classList.toggle('hidden', !isHidden);
        });
    }

    // Toggle Confirm Password
    const toggleConfirm = document.getElementById('toggleConfirmPassword');
    const confirmInput = document.getElementById('password_confirmation');
    const eyeIconConfirm = document.getElementById('eyeIconConfirm');
    const eyeOffIconConfirm = document.getElementById('eyeOffIconConfirm');

    if (toggleConfirm) {
        toggleConfirm.addEventListener('click', function () {
            const isHidden = confirmInput.type === 'password';
            confirmInput.type = isHidden ? 'text' : 'password';
            eyeIconConfirm.classList.toggle('hidden', isHidden);
            eyeOffIconConfirm.classList.toggle('hidden', !isHidden);
        });
    }
</script>
@endpush

@endsection
