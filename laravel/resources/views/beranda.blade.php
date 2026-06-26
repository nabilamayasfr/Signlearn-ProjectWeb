@extends('layout.app')

@section('title', 'SignLearn - Beranda')

@section('content')

@include('layout.navbar')

<div class="min-h-screen bg-gradient-to-br from-pink-100 via-pink-50 to-pink-100 font-[Poppins]">

  <!-- HERO -->
  <section class="grid md:grid-cols-2 gap-8 items-center px-6 md:px-12 py-10 animate-fade-in">

    <!-- TEXT -->
    <div>
      <h1 class="text-3xl md:text-5xl font-extrabold text-[#492F48] leading-tight mb-4">
        Selamat Datang
        <span class="text-pink-600">
          {{ explode(' ', auth()->user()->name ?? 'Ara')[0] }}!
        </span><br>
        Mari Belajar Bahasa Isyarat<br>
        Secara Mandiri
      </h1>

      <p class="text-[#492F48] leading-relaxed mb-6 max-w-md">
        SIGNLEARN siap membantu kamu belajar dan melatih bahasa isyarat dengan mudah dan menyenangkan.
      </p>

      <div class="flex flex-wrap gap-3">
        <a href="{{ route('pembelajaran.index') }}"
           class="px-6 py-2 rounded-xl border-2 border-pink-600 text-pink-600 font-bold bg-white hover:bg-pink-100 transition">
           Mulai Belajar
        </a>

        <a href="{{ route('latihan') }}"
           class="px-6 py-2 rounded-xl bg-pink-600 text-white font-bold shadow-lg hover:bg-pink-800 hover:-translate-y-1 transition">
           Mulai Latihan
        </a>
      </div>
    </div>

    <!-- IMAGE -->
 <div class="flex justify-center items-center relative min-h-[300px]">

    <div class="absolute w-[280px] h-[280px] rounded-full
    bg-[radial-gradient(circle,_#F7DAED_0%,_transparent_70%)]">
    </div>

    <img src="{{ asset('assets/hero-illustration.webp') }}"
         class="relative w-full max-w-[380px]
         drop-shadow-[0_18px_30px_rgba(200,45,133,0.18)]
         animate-[heroFloat_5s_ease-in-out_infinite]">
</div>
  </section>

  <!-- AKSES CEPAT -->
  <section class="px-6 md:px-12 pb-8">
    <p class="text-xl font-extrabold text-[#2D1A2E] mb-4">
      Akses Cepat
    </p>

    <div class="grid md:grid-cols-3 gap-4">

      <!-- CARD Belajar SIBI -->
      <a href="{{ route('pembelajaran.index') }}"
          class="flex justify-between items-center p-5 rounded-2xl bg-white border-2 border-pink-200 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

        <div>
          <h3 class="font-extrabold text-[#2D1A2E] mb-3">
            Belajar<br>SIBI
          </h3>

          <span class="px-4 py-1 text-sm rounded-full bg-pink-600 text-white font-semibold shadow-md">
            Mulai ›
          </span>
        </div>

        <img src="{{ asset('assets/quick-sibi.png') }}"
             class="w-16"
             alt="SIBI">
      </a>

      <!-- CARD Belajar Bisindo -->
      <a href="{{ route('pembelajaran.index') }}"
         class="flex justify-between items-center p-5 rounded-2xl bg-white border-2 border-pink-200 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

        <div>
          <h3 class="font-extrabold text-[#2D1A2E] mb-3">
            Belajar<br>Bisindo
          </h3>

          <span class="px-4 py-1 text-sm rounded-full bg-pink-600 text-white font-semibold shadow-md">
            Mulai ›
          </span>
        </div>

        <img src="{{ asset('assets/quick-bisindo.png') }}"
             class="w-16"
             alt="Bisindo">
      </a>

      <!-- CARD Latihan -->
      <a href="{{ route('latihan') }}"
         class="flex justify-between items-center p-5 rounded-2xl bg-white border-2 border-pink-200 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

        <div>
          <h3 class="font-extrabold text-[#2D1A2E] mb-3">
            Latihan Bahasa<br>Isyarat
          </h3>

          <span class="px-4 py-1 text-sm rounded-full bg-pink-600 text-white font-semibold shadow-md">
            Mulai ›
          </span>
        </div>

        <img src="{{ asset('assets/quick-latihan.png') }}"
             class="w-16"
             alt="Latihan">
      </a>

    </div>
  </section>

  <!-- KEMAJUAN -->
  <section class="px-6 md:px-12 pb-8">

    <p class="text-xl font-extrabold text-[#2D1A2E] mb-4">
      Kemajuan Belajar
    </p>

    <div class="bg-white rounded-2xl p-6 shadow-md border border-pink-100">

      <h2 class="font-extrabold text-lg mb-1">
        Kemajuan Belajar
      </h2>

      @php
        $mastered = $userProgress->mastered ?? 0;
        $total    = $userProgress->total    ?? 52;
        $pct      = $userProgress->pct      ?? 0;
      @endphp

      <p class="text-sm text-black mb-4">
          Kamu sudah menguasai <strong>{{ $mastered }}/{{ $total }}</strong> huruf
          <span class="text-pink-600 font-bold">({{ $pct }}%)</span>
          <span class="text-gray-400 text-xs block mt-0.5">26 huruf BISINDO + 26 huruf SIBI</span>
      </p>

      <div class="w-full h-3 bg-pink-100 rounded-full overflow-hidden mb-2">
        <div class="h-full bg-gradient-to-r from-pink-500 to-pink-700"
             style="width: {{ $pct }}%">
        </div>
      </div>

      <p class="text-sm font-bold text-pink-600">
        {{ $pct }}% selesai
      </p>

    </div>
  </section>

  <!-- DETEKSI ISYARAT -->
  <section class="px-6 md:px-12 pb-10">

    <p class="text-xl font-extrabold text-[#2D1A2E] mb-4">
      Deteksi Isyarat
    </p>

    <div class="grid md:grid-cols-2 gap-4">

      <!-- Card BISINDO -->
      <div class="bg-white rounded-2xl p-6 shadow-md border-2 border-pink-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
          </div>
          <h3 class="text-lg font-extrabold text-[#2D1A2E]">Deteksi Isyarat BISINDO</h3>
        </div>

        <p class="text-sm text-gray-500 mb-4">
          Deteksi bahasa isyarat BISINDO menggunakan kamera. Pilih huruf A-Z dan praktikkan langsung!
        </p>

        <div class="flex items-center gap-2 mb-4">
          <div class="flex-1">
            <select id="hurufBisindo" class="w-full px-3 py-2 rounded-xl border border-pink-200 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm">
              @foreach(range('A', 'Z') as $huruf)
                <option value="{{ $huruf }}">Huruf {{ $huruf }}</option>
              @endforeach
            </select>
          </div>
          <button onclick="startDetection('BISINDO')"
                  class="px-4 py-2 rounded-xl bg-pink-600 text-white font-bold shadow-lg hover:bg-pink-700 hover:-translate-y-0.5 transition text-sm">
            <span class="flex items-center gap-1">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              Deteksi
            </span>
          </button>
        </div>

        <div class="text-xs text-gray-400 flex items-center gap-1">
          <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
          Kamera siap digunakan
        </div>
      </div>

      <!-- Card SIBI -->
      <div class="bg-white rounded-2xl p-6 shadow-md border-2 border-pink-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
          </div>
          <h3 class="text-lg font-extrabold text-[#2D1A2E]">Deteksi Isyarat SIBI</h3>
        </div>

        <p class="text-sm text-gray-500 mb-4">
          Deteksi bahasa isyarat SIBI menggunakan kamera. Pilih huruf A-Z dan praktikkan langsung!
        </p>

        <div class="flex items-center gap-2 mb-4">
          <div class="flex-1">
            <select id="hurufSibi" class="w-full px-3 py-2 rounded-xl border border-pink-200 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm">
              @foreach(range('A', 'Z') as $huruf)
                <option value="{{ $huruf }}">Huruf {{ $huruf }}</option>
              @endforeach
            </select>
          </div>
          <button onclick="startDetection('SIBI')"
                  class="px-4 py-2 rounded-xl bg-pink-600 text-white font-bold shadow-lg hover:bg-pink-700 hover:-translate-y-0.5 transition text-sm">
            <span class="flex items-center gap-1">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              Deteksi
            </span>
          </button>
        </div>

        <div class="text-xs text-gray-400 flex items-center gap-1">
          <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
          Kamera siap digunakan
        </div>
      </div>

    </div>
  </section>

</div>

@push('scripts')
<script>
  function startDetection(module) {
    let huruf;
    if (module === 'BISINDO') {
      huruf = document.getElementById('hurufBisindo').value;
    } else {
      huruf = document.getElementById('hurufSibi').value;
    }

    // Redirect ke halaman praktik dengan parameter
    window.location.href = `/praktik/${module.toLowerCase()}/${huruf.toLowerCase()}`;
  }
</script>
@endpush

@include('layout.footer')

@endsection
