@extends('layout.app')

@section('title', 'SignLearn - FAQ')

@section('content')

@include('layout.navbar')

<div class="bg-pink-50 min-h-screen">

    {{-- FAQ SECTION --}}
    <section class="px-6 pt-10 pb-0">
        <div class="max-w-7xl mx-auto">

            <div class="flex items-start gap-2 mb-1">
                <span class="text-3xl font-black text-gray-800 leading-tight">?</span>
                <h1 class="text-3xl font-black text-gray-800 leading-tight">
                    Pertanyaan yang sering di ajukan <span class="text-pink-500">(FAQ)</span>
                </h1>
            </div>
            <p class="text-gray-500 text-sm mb-8 ml-[42px]">Temukan jawaban untuk pertanyaan yang sering ditanyakan.</p>

            @php
                $faqs = [
                    ['q' => 'Apa itu SIGNLEARN?', 'a' => 'SIGNLEARN adalah aplikasi pembelajaran bahasa isyarat berbasis Artificial Intelligence (AI) yang membantu pengguna belajar dan melatih gesture bahasa isyarat secara mandiri melalui video dan latihan berbasis kamera.'],
                    ['q' => 'Apakah SIGNLEARN gratis?', 'a' => 'Ya, SIGNLEARN dapat digunakan secara gratis untuk belajar bahasa isyarat. Beberapa fitur tambahan dapat dikembangkan di masa depan.'],
                    ['q' => 'Apa perbedaan SIBI dan BISINDO?', 'a' => 'SIBI (Sistem Isyarat Bahasa Indonesia) adalah bahasa isyarat yang dikembangkan oleh pemerintah dan mengikuti tata bahasa Indonesia. BISINDO (Bahasa Isyarat Indonesia) adalah bahasa isyarat alami yang digunakan oleh komunitas tuli di Indonesia dengan tata bahasanya sendiri.'],
                    ['q' => 'Bagaimana cara menggunakan fitur latihan?', 'a' => 'Masuk ke halaman Latihan, pilih materi yang ingin dilatih, lalu izinkan akses kamera. Aplikasi akan mendeteksi gerakan tangan kamu secara real-time dan memberikan feedback langsung.'],
                    ['q' => 'Apakah data dan video latihan saya aman?', 'a' => 'Ya, data dan video kamu aman. Kamera hanya digunakan secara lokal untuk mendeteksi gerakan dan tidak ada rekaman yang disimpan atau dikirim ke server.'],
                    ['q' => 'Apakah aplikasi ini cocok untuk anak-anak?', 'a' => 'Ya, SIGNLEARN dirancang dengan tampilan yang ramah dan mudah digunakan oleh semua usia, termasuk anak-anak. Konten disajikan secara visual dan interaktif.'],
                    ['q' => 'Apakah SIGNLEARN gratis?', 'a' => 'Ya, SIGNLEARN sepenuhnya gratis untuk diakses. Daftar sekarang dan mulai perjalanan belajar bahasa isyarat kamu!'],
                ];
            @endphp

            @foreach($faqs as $i => $faq)
            <div class="bg-white rounded-2xl shadow-md mb-3 overflow-hidden hover:shadow-lg" id="faq-{{ $i }}">
                <button class="w-full flex items-center gap-3 p-4 text-left cursor-pointer focus:outline-none" onclick="toggleFaq({{ $i }})">
                    <span class="w-7 h-7 rounded-full bg-pink-500 flex items-center justify-center text-white font-bold text-xs shrink-0">?</span>
                    <span class="flex-1 font-bold text-gray-800 text-sm text-left">{{ $faq['q'] }}</span>
                    <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 shrink-0 faq-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <!-- faq-body dengan Tailwind transition -->
                <div class="faq-body transition-all duration-350 ease-in-out overflow-hidden" style="max-height: 0px;" id="faq-body-{{ $i }}">
                    <div class="pl-10 pr-6 pb-4 pt-3 border-t border-pink-100">
                        <p class="text-sm text-gray-600 leading-relaxed text-left">{{ $faq['a'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- CARA PENGGUNAAN --}}
    <section class="px-6 py-10 bg-pink-50">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-2xl px-8 py-5 mb-5 shadow-sm text-center">
                <h2 class="text-2xl font-black text-gray-800 mb-0.5">Cara Penggunaan</h2>
                <p class="text-gray-500 text-sm">Ikuti langkah mudah berikut untuk mulai belajar di SIGNLEARN.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Card 1 -->
                <div class="bg-white rounded-xl border border-pink-100 shadow-md p-4 flex flex-col items-center text-center transition-all duration-200 hover:-translate-y-1 hover:shadow-xl hover:border-pink-200 h-full">
                    <div class="w-12 h-12 rounded-full bg-pink-100 flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-gray-700 leading-relaxed flex-1">1. Masuk atau Daftar ke halaman Aplikasi SIGNLEARN</p>
                </div>
                <!-- Card 2 -->
                <div class="bg-white rounded-xl border border-pink-100 shadow-md p-4 flex flex-col items-center text-center transition-all duration-200 hover:-translate-y-1 hover:shadow-xl hover:border-pink-200 h-full">
                    <div class="w-12 h-12 rounded-full bg-pink-100 flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-gray-700 leading-relaxed flex-1">2. Pilih huruf yang ingin kamu pelajari di halaman pembelajaran.</p>
                </div>
                <!-- Card 3 -->
                <div class="bg-white rounded-xl border border-pink-100 shadow-md p-4 flex flex-col items-center text-center transition-all duration-200 hover:-translate-y-1 hover:shadow-xl hover:border-pink-200 h-full">
                    <div class="w-12 h-12 rounded-full bg-pink-100 flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-gray-700 leading-relaxed flex-1">3. Tiru gerakan yang ditampilkan dan gunakan kamera untuk deteksi real-time.</p>
                </div>
                <!-- Card 4 -->
                <div class="bg-white rounded-xl border border-pink-100 shadow-md p-4 flex flex-col items-center text-center transition-all duration-200 hover:-translate-y-1 hover:shadow-xl hover:border-pink-200 h-full">
                    <div class="w-12 h-12 rounded-full bg-pink-100 flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-gray-700 leading-relaxed flex-1">4. Lihat feedback dan tingkatkan latihanmu.</p>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
    var openIndex = null;
    function toggleFaq(index) {
        var card = document.getElementById('faq-' + index);
        var body = document.getElementById('faq-body-' + index);
        var chevron = card.querySelector('.faq-chevron');
        if (openIndex === index) {
            body.style.maxHeight = '0px';
            card.classList.remove('border-pink-300', 'shadow-lg');
            chevron.classList.remove('rotate-180', 'text-pink-500');
            openIndex = null;
        } else {
            if (openIndex !== null) {
                var prevBody = document.getElementById('faq-body-' + openIndex);
                var prevCard = document.getElementById('faq-' + openIndex);
                var prevChevron = prevCard.querySelector('.faq-chevron');
                prevBody.style.maxHeight = '0px';
                prevCard.classList.remove('border-pink-300', 'shadow-lg');
                prevChevron.classList.remove('rotate-180', 'text-pink-500');
            }
            body.style.maxHeight = body.scrollHeight + 'px';
            card.classList.add('border-pink-300', 'shadow-lg');
            chevron.classList.add('rotate-180', 'text-pink-500');
            openIndex = index;
        }
    }
</script>
@endpush
@include('layout.footer')
@endsection
