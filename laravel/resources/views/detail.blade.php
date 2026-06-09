@extends('layout.app')

@section('title', 'SignLearn - Detail Huruf ' . strtoupper($huruf))

@section('content')
<div class="min-h-screen pb-24" style="background: linear-gradient(135deg, #FEE6F2 0%, #FCE7F3 60%, #F3E8FF 100%);">

    {{-- TOP BAR --}}
    <div class="flex items-center justify-between px-4 md:px-8 py-4 flex-wrap gap-3">

        {{-- Kembali --}}
        <a href="{{ route('pembelajaran.index') }}" class="flex items-center gap-1.5 text-pink-500 font-semibold text-sm hover:text-pink-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>

        {{-- Progress Belajar --}}
        <div class="flex flex-col items-center flex-1">
            <p class="text-[10px] text-gray-400 font-medium tracking-wide mb-2">Progress Belajar</p>
            <div class="flex items-center justify-center">
                @php
                    $hurufList = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
                    $currentIndex = array_search(strtoupper($huruf), $hurufList);
                    if ($currentIndex === false) $currentIndex = 0;
                    // Tampilkan 6 huruf sliding window berpusat di huruf aktif
                    $windowStart = max(0, min($currentIndex - 2, count($hurufList) - 6));
                    $displayList = array_slice($hurufList, $windowStart, 6, true);
                @endphp
                @foreach($displayList as $absIndex => $h)
                    <div class="flex flex-col items-center">
                        <a href="{{ route('pembelajaran.huruf', ['modul' => $modul, 'huruf' => strtolower($h)]) }}"
                           class="flex flex-col items-center group">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all
                                {{ $absIndex < $currentIndex
                                    ? 'bg-pink-500 text-white'
                                    : ($absIndex === $currentIndex
                                        ? 'bg-white border-[3px] border-pink-500 text-pink-500'
                                        : 'bg-white border-2 border-gray-200 text-gray-300 group-hover:border-pink-300 group-hover:text-pink-400') }}">
                                @if($absIndex < $currentIndex)
                                    <svg class="w-3 h-3" fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @else
                                    {{ $h }}
                                @endif
                            </div>
                            <span class="text-[10px] mt-1 {{ $absIndex === $currentIndex ? 'text-pink-500 font-semibold' : 'text-gray-400' }}">{{ $h }}</span>
                        </a>
                    </div>
                    @if(!$loop->last)
                        <div class="w-5 md:w-7 h-0.5 mb-4 {{ $absIndex < $currentIndex ? 'bg-pink-500' : 'bg-gray-200' }}"></div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="w-16"></div>

    </div>

    {{-- HURUF HEADER --}}
    <div class="flex items-center gap-4 px-4 md:px-8 pb-5">
        <div class="w-16 h-16 bg-gradient-to-br from-pink-400 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg">
            <span class="text-3xl font-black text-white">{{ strtoupper($huruf) }}</span>
        </div>
        <div>
            <h1 class="text-xl font-extrabold text-gray-800">Huruf {{ strtoupper($huruf) }}</h1>
            <p class="text-sm font-semibold text-pink-500 mt-0.5">Modul {{ strtoupper($modul) }}</p>
        </div>
    </div>

    {{-- MAIN GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 px-4 md:px-8">

        {{-- KIRI: Lihat Isyarat --}}
        <div class="bg-white rounded-2xl shadow-sm border border-pink-50 p-5">
            <div class="flex items-center gap-2.5 mb-4">
                <div class="w-8 h-8 bg-pink-100 rounded-full flex items-center justify-center text-pink-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                    </svg>
                </div>
                <h2 class="text-base font-bold text-gray-800">Lihat Isyarat</h2>
            </div>

            {{-- Gambar + zoom inline --}}
            <div id="gambarContainer"
                 class="relative bg-pink-50 rounded-xl flex items-center justify-center overflow-hidden"
                 style="min-height:220px; max-height:320px;">
                @if($dataModul->thumbnail)
                    <img src="{{ asset($dataModul->thumbnail) }}"
                         id="gambarIsyarat"
                         alt="Huruf {{ strtoupper($huruf) }}"
                         class="object-contain transition-all duration-300 cursor-zoom-in select-none"
                         style="max-height:220px; max-width:100%; transform:scale(1); transform-origin:center center;"
                         onclick="toggleZoom(this)">

                    <button id="zoomBtn"
                            onclick="toggleZoom(document.getElementById('gambarIsyarat'))"
                            class="absolute bottom-3 left-3 flex items-center gap-1.5 bg-white text-gray-500 text-xs font-medium px-3 py-1.5 rounded-lg shadow-sm hover:shadow-md transition z-10">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                        </svg>
                        <span id="zoomLabel">Perbesar</span>
                    </button>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 mx-auto text-pink-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="3"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <path d="M21 15l-5-5L5 21"/>
                        </svg>
                        <p class="text-gray-300 text-sm mt-2">Thumbnail belum tersedia</p>
                    </div>
                @endif
            </div>

            {{-- Tip --}}
            <div class="mt-4 flex items-start gap-2.5 bg-yellow-50 border border-yellow-200 rounded-xl px-4 py-3">
                <p class="text-sm text-yellow-800">{{ $dataModul->penjelasan ?? 'Penjelasan belum tersedia.' }}</p>
            </div>
        </div>

        {{-- KANAN: Cara Membuat Isyarat --}}
        <div class="bg-white rounded-2xl shadow-sm border border-pink-50 p-5">
            <div class="flex items-center gap-2.5 mb-4">
                <div class="w-8 h-8 bg-pink-100 rounded-full flex items-center justify-center text-pink-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                        <rect x="9" y="3" width="6" height="4" rx="2"/>
                        <line x1="9" y1="12" x2="15" y2="12"/><line x1="9" y1="16" x2="13" y2="16"/>
                    </svg>
                </div>
                <h2 class="text-base font-bold text-gray-800">Cara Membuat Isyarat</h2>
            </div>

            @php
                $langkah = $dataModul->langkah ?? [];
                if(empty($langkah)) {
                    $langkah = [
                        ['judul' => 'Bentuk tangan seperti huruf ' . strtoupper($huruf) . '.', 'deskripsi' => 'Lengkungkan jari-jari membentuk huruf ' . strtoupper($huruf) . ' dengan benar.'],
                        ['judul' => 'Jari tidak boleh bengkok.', 'deskripsi' => 'Pastikan jari-jari tidak menekuk ke dalam, tetap membentuk lengkungan.'],
                        ['judul' => 'Telapak tangan menghadap ke depan.', 'deskripsi' => 'Hadapkan telapak tangan ke depan agar mudah terlihat.'],
                    ];
                }
            @endphp

            <div class="flex flex-col gap-3 mb-4">
                @foreach($langkah as $i => $step)
                <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-3 border border-gray-100">
                    <div class="w-7 h-7 bg-pink-500 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                        {{ $i + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-800 leading-snug">{{ $step['judul'] }}</p>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $step['deskripsi'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-sm font-bold text-amber-800">Tips Penting</span>
                </div>
                <p class="text-xs text-amber-700 leading-relaxed">
                    Gunakan tangan yang nyaman dan lakukan gerakan di depan kamera agar AI dapat mendeteksi dengan baik.
                </p>
            </div>
        </div>

    </div>
</div>

{{-- BOTTOM BAR --}}
<div class="fixed bottom-0 left-0 right-0 bg-white shadow-[0_-4px_20px_rgba(0,0,0,0.08)] flex items-center justify-between px-4 md:px-8 py-3 z-50">

    @php
        $hurufArr = range('a', 'z');
        $idx = array_search(strtolower($huruf), $hurufArr);
        $prevHuruf = $idx > 0 ? $hurufArr[$idx - 1] : null;
        $nextHuruf = $idx < count($hurufArr) - 1 ? $hurufArr[$idx + 1] : null;
    @endphp

    {{-- Prev --}}
    <div class="w-28 md:w-36">
        @if($prevHuruf)
        <a href="{{ route('pembelajaran.huruf', ['modul' => $modul, 'huruf' => $prevHuruf]) }}"
           class="flex items-center gap-1.5 text-pink-500 hover:text-pink-700 transition">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            <span class="leading-tight">
                <small class="block text-[10px] text-gray-400 font-medium">Huruf Sebelumnya</small>
                <strong class="block text-sm font-bold">{{ strtoupper($prevHuruf) }}</strong>
            </span>
        </a>
        @else
        <div class="opacity-30 flex items-center gap-1.5">
            <svg class="w-4 h-4 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            <span class="leading-tight">
                <small class="block text-[10px] text-gray-400 font-medium">Huruf Sebelumnya</small>
                <strong class="block text-sm font-bold text-gray-400">-</strong>
            </span>
        </div>
        @endif
    </div>

    {{-- Mulai Praktik --}}
    <a href="{{ route('praktik.huruf', ['modul' => $modul, 'huruf' => $huruf]) }}"
       class="flex items-center gap-3 bg-gradient-to-r from-pink-400 to-pink-600 text-white px-6 md:px-8 py-3 rounded-full shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
            <path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/>
            <circle cx="12" cy="13" r="4"/>
        </svg>
        <span class="leading-tight">
            <strong class="block text-sm font-bold">Mulai Praktik Sekarang</strong>
            <small class="block text-[11px] opacity-90">Deteksi gerakan menggunakan AI</small>
        </span>
    </a>

    {{-- Next --}}
    <div class="w-28 md:w-36 flex justify-end">
        @if($nextHuruf)
        <a href="{{ route('pembelajaran.huruf', ['modul' => $modul, 'huruf' => $nextHuruf]) }}"
           class="flex items-center gap-1.5 text-pink-500 hover:text-pink-700 transition">
            <span class="leading-tight text-right">
                <small class="block text-[10px] text-gray-400 font-medium">Huruf Selanjutnya</small>
                <strong class="block text-sm font-bold">{{ strtoupper($nextHuruf) }}</strong>
            </span>
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
        @else
        <div class="opacity-30 flex items-center gap-1.5">
            <span class="leading-tight text-right">
                <small class="block text-[10px] text-gray-400 font-medium">Huruf Selanjutnya</small>
                <strong class="block text-sm font-bold text-gray-400">-</strong>
            </span>
            <svg class="w-4 h-4 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
        @endif
    </div>

</div>

@push('scripts')
<script>
    let isZoomed = false;

    function toggleZoom(img) {
        const container = document.getElementById('gambarContainer');
        const label = document.getElementById('zoomLabel');

        if (!isZoomed) {
            // Perbesar: lepas overflow container, naikkan max-height, scale gambar
            container.style.maxHeight = 'none';
            container.style.overflow = 'visible';
            img.style.maxHeight = 'none';
            img.style.transform = 'scale(1.9)';
            img.style.transformOrigin = 'center center';
            img.style.cursor = 'zoom-out';
            img.style.marginTop = '80px';
            img.style.marginBottom = '80px';
            label.textContent = 'Perkecil';
            isZoomed = true;
        } else {
            // Perkecil: kembalikan semua
            container.style.maxHeight = '320px';
            container.style.overflow = 'hidden';
            img.style.maxHeight = '220px';
            img.style.transform = 'scale(1)';
            img.style.cursor = 'zoom-in';
            img.style.marginTop = '0';
            img.style.marginBottom = '0';
            label.textContent = 'Perbesar';
            isZoomed = false;
        }
    }
</script>
@endpush

@endsection
