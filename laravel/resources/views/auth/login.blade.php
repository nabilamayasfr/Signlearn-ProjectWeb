@extends('layout.app')

@section('title', 'SignLearn - Masuk')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
    .login-page * {
        font-family: 'Poppins', sans-serif;
    }
    .login-page input {
        font-family: 'Poppins', sans-serif;
    }
</style>
@endpush

@section('content')

<div class="login-page flex min-h-screen">

    {{-- ===== KIRI: Branding panel dengan background pink ===== --}}
    <div class="w-1/2 min-h-screen flex flex-col justify-center px-12 py-10"
        style="background: linear-gradient(160deg, #F9C5E2 0%, #C82D85 55%, #951651 100%);">

        {{-- Konten di-center secara vertikal --}}
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
                Platform interaktif berbasis AI untuk mempelajari Bahasa Isyarat kapan saja dan di mana saja
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
            <div class="mb-8">
                <h1 class="font-extrabold text-gray-800 text-[1.9rem] leading-tight">
                    Masuk Ke <span class="text-[#C82D85]">SIGNLEARN</span>
                </h1>
                <p class="text-gray-500 text-[0.85rem] mt-1">
                    Belajar Bahasa Isyarat dengan AI Secara Mandiri
                </p>
            </div>

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 rounded-xl px-4 py-2 mb-4">
                    <p class="text-green-600 text-xs text-center">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-2 mb-4">
                    <p class="text-red-500 text-xs text-center">{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block font-medium mb-1.5 text-[0.75rem] text-gray-500">Email</label>
                    <input type="text" name="login"
                        value="{{ old('login') }}"
                        autocomplete="username"
                        class="w-full rounded-2xl px-4 py-3 bg-gray-100 border-0 focus:outline-none focus:ring-2 focus:ring-[#C82D85] transition text-[0.875rem] @error('login') ring-2 ring-red-400 @enderror" />
                    @error('login')
                        <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-medium mb-1.5 text-[0.75rem] text-gray-500">Kata Sandi</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            autocomplete="current-password"
                            class="w-full rounded-2xl px-4 py-3 bg-gray-100 border-0 focus:outline-none focus:ring-2 focus:ring-[#C82D85] transition pr-10 text-[0.875rem] @error('password') ring-2 ring-red-400 @enderror" />
                        <button type="button" id="togglePassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eyeOffIcon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" id="remember"
                            class="rounded border-gray-300 text-[#C82D85] focus:ring-[#C82D85]"
                            {{ old('remember') ? 'checked' : '' }} />
                        <span class="font-medium text-[0.75rem] text-gray-500">Ingat saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="font-semibold hover:underline text-[0.75rem] text-[#C82D85]">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>

                {{-- Tombol Login --}}
                <button type="submit" class="w-full px-[26px] py-[11px] rounded-[12px] bg-[#C82D85] text-white shadow-[0_8px_24px_rgba(200,45,133,0.35)] hover:bg-[#951651] transition font-bold">
                    Masuk
                </button>

                <p class="text-center pt-1 text-[0.78rem] text-gray-500">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-bold hover:underline text-gray-700">Daftar</a>
                </p>
            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>
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
</script>
@endpush

@endsection
