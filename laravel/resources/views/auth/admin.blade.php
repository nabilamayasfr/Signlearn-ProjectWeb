@extends('layout.app')

@section('title', 'SignLearn - Admin Login')

@section('content')

<div class="min-h-screen flex items-center justify-center p-4" style="background-color: #FEE6F2;">
    <div class="w-full max-w-4xl rounded-3xl overflow-hidden shadow-xl flex" style="min-height: 500px;">

        {{-- KIRI: Ilustrasi --}}
        <div class="w-1/2 flex items-center justify-center"
            style="background: linear-gradient(180deg, #F9C5E2 0%, #C07EB5 100%);">
            <img src="{{ asset('assets/logo.png') }}"
                alt="Mascot SignLearn"
                class="max-w-[80%] max-h-[80%] object-contain" />
        </div>

        {{-- KANAN: Form Admin --}}
        <div class="w-1/2 flex flex-col justify-center px-10 py-8 bg-white">

            <div class="flex justify-center mb-3">
                <img src="{{ asset('assets/logo.png') }}"
                    alt="Logo SignLearn"
                    class="h-16 object-contain" />
            </div>

            <h1 class="text-2xl font-bold text-center text-gray-800 mb-1">
                Admin <span style="color: #C07EB5;">SignLearn</span>
            </h1>
            <p class="text-center text-gray-500 text-xs mb-5">
                Masuk sebagai administrator
            </p>

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-2 mb-4">
                    <p class="text-red-500 text-xs text-center">{{ session('error') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-2 mb-4">
                    <p class="text-red-500 text-xs text-center">Username atau password salah.</p>
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-3">
                @csrf

                <div>
                    <label class="block text-xs text-gray-600 mb-1 ml-1">Email Admin</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm
                            bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-300 transition"
                        placeholder="admin@signlearn.com" />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs text-gray-600 mb-1 ml-1">Kata Sandi</label>
                    <input type="password" name="password"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm
                            bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-300 transition" />
                </div>

                <button type="submit"
                    class="w-full py-2.5 rounded-xl text-white font-semibold transition hover:opacity-90"
                    style="background-color: #C07EB5;">
                    Masuk sebagai Admin
                </button>
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
