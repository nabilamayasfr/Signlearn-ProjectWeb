<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignLearn</title>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    keyframes: {
                        heroFloat: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-12px)' },
                        },
                        fadeUp: {
                            from: { opacity: '0', transform: 'translateY(24px)' },
                            to: { opacity: '1', transform: 'translateY(0)' },
                        },
                    },
                    animation: {
                        heroFloat: 'heroFloat 5s ease-in-out infinite',
                        fadeUp: 'fadeUp 0.7s ease',
                    },
                },
            },
        };
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="font-poppins bg-[#FEE6F2] text-[#5B2B63] overflow-x-hidden">
<div class="relative">

    <!-- NAVBAR -->
    <header class="flex items-center justify-between px-[48px] py-[18px] sticky top-0 z-[200] bg-[#FEE6F2]">

        <div class="flex items-center">
            <img src="{{ asset('assets/tulisan.png') }}" class="w-[130px]">
        </div>

        <nav class="hidden md:flex gap-[36px] text-[14.5px] text-[#492F48] font-medium">
            <a href="#" class="relative pb-[3px] hover:text-[#C82D85] group">
                Beranda
                <span class="absolute left-0 bottom-0 w-0 h-[2px] bg-[#C82D85] rounded transition-all duration-200 group-hover:w-full"></span>
            </a>
            <a href="{{ route('login') }}" class="relative pb-[3px] hover:text-[#C82D85] group">
                Pembelajaran
                <span class="absolute left-0 bottom-0 w-0 h-[2px] bg-[#C82D85] rounded transition-all duration-200 group-hover:w-full"></span>
            </a>
            <a href="{{ route('login') }}" class="relative pb-[3px] hover:text-[#C82D85] group">
                Latihan
                <span class="absolute left-0 bottom-0 w-0 h-[2px] bg-[#C82D85] rounded transition-all duration-200 group-hover:w-full"></span>
            </a>
        </nav>

        <div class="flex gap-[12px] items-center">
            <a href="{{ route('login') }}"
               class="px-[26px] py-[11px] text-[14px] font-semibold rounded-[12px] border-2 border-[#742958] text-[#742958] shadow-[0_3px_10px_rgba(116,41,88,0.10)] hover:bg-[#F7DAED] hover:border-[#C82D85] hover:text-[#C82D85] transition">
                Masuk
            </a>

            <a href="{{ route('register') }}"
               class="px-[26px] py-[11px] text-[14px] font-semibold rounded-[12px] bg-[#C82D85] text-white shadow-[0_8px_24px_rgba(200,45,133,0.35)] hover:bg-[#951651] hover:shadow-[0_14px_36px_rgba(200,45,133,0.5)] hover:-translate-y-[2px] hover:scale-[1.02] active:scale-[0.98] transition">
                Daftar
            </a>
        </div>
    </header>

    <!-- HERO -->
    <section class="grid md:grid-cols-[1.15fr_0.85fr] items-center gap-[40px] px-6 md:px-12 py-[48px]">

        <div class="animate-fadeUp">
            <h1 class="text-[2rem] md:text-[3rem] leading-[1.25] font-extrabold mb-5 tracking-tight">
                Belajar <span class="text-[#C82D85]">Bahasa Isyarat</span><br>
                Dengan AI Secara<br>
                Mandiri
            </h1>

            <p class="text-[1rem] md:text-[1.1rem] leading-[1.75] text-[#7A4B78] mb-8 max-w-lg">
                Aplikasi cerdas berbasis AI untuk belajar dan melatih bahasa isyarat
                dengan mudah dan menyenangkan.
            </p>

            <div class="flex gap-[14px] flex-wrap">
                <a href="{{ route('pembelajaran.index') }}"
                   class="px-[26px] py-[11px] rounded-[12px] bg-white text-[#C82D85] border-[1.5px] border-[#F7C4DF] hover:bg-[#F7DAED] shadow transition">
                    Mulai Belajar
                </a>

                <a href="{{ route('login') }}"
                   class="px-[26px] py-[11px] rounded-[12px] bg-[#C82D85] text-white shadow-[0_8px_24px_rgba(200,45,133,0.35)] hover:bg-[#951651] transition">
                    Coba Latihan
                </a>
            </div>
        </div>

        <div class="relative flex items-center justify-center min-h-[400px]">
            <div class="absolute w-[330px] h-[330px] rounded-full bg-[radial-gradient(circle,#F7DAED_0%,transparent_70%)]"></div>
            <img src="{{ asset('assets/hero-illustration.png') }}"
                 class="relative max-w-[440px] drop-shadow-[0_24px_40px_rgba(200,45,133,0.2)] animate-heroFloat">
        </div>
    </section>

    <!-- FEATURES -->
    <section class="px-6 md:px-12">
        <div class="bg-[#FEF1F9] rounded-[28px] shadow-[0_6px_22px_rgba(200,45,133,0.13)] p-[48px_36px] mb-[40px]">

            <h2 class="text-center text-[2rem] font-bold mb-[36px] tracking-[-0.3px]">
                Fitur Utama SIGNLEARN
            </h2>

            <div class="grid md:grid-cols-3 gap-[24px]">

                <!-- Card 1 - Modul Pembelajaran -->
                <div class="bg-white rounded-[18px] p-[30px_24px] text-center
                            shadow-[0_6px_22px_rgba(200,45,133,0.13)]
                            flex flex-col items-center justify-between
                            hover:-translate-y-[8px] hover:scale-[1.02]
                            hover:shadow-[0_18px_48px_rgba(250,150,200,0.65)] transition">
                    <div class="w-[80px] h-[80px] rounded-full bg-gradient-to-br from-pink-100 to-pink-200 flex items-center justify-center mb-4">
                        <svg class="w-[40px] h-[40px] text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332-.477-4.5-1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-[1.2rem] font-semibold text-[#BE3B7A] mb-[12px]">
                        Modul Pembelajaran
                    </h3>
                    <p class="text-[0.95rem] text-[#492F48] leading-[1.7]">
                        Belajar bahasa isyarat SIBI dan BISINDO melalui modul dan video tutorial.
                    </p>
                </div>

                <!-- Card 2 - Latihan Gesture AI -->
                <div class="bg-white rounded-[18px] p-[30px_24px] text-center
                            shadow-[0_6px_22px_rgba(200,45,133,0.13)]
                            flex flex-col items-center justify-between
                            hover:-translate-y-[8px] hover:scale-[1.02]
                            hover:shadow-[0_18px_48px_rgba(250,150,200,0.65)] transition">
                    <div class="w-[80px] h-[80px] rounded-full bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center mb-4">
                        <svg class="w-[40px] h-[40px] text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m0 14v1m4-8h1M7 12H6m3-5.5l.707.707M14.293 16.707l.707.707M17.5 9l-.707.707M6.5 14.293l-.707.707"/>
                        </svg>
                    </div>
                    <h3 class="text-[1.2rem] font-semibold text-[#BE3B7A] mb-[12px]">
                        Latihan Gesture AI
                    </h3>
                    <p class="text-[0.95rem] text-[#492F48] leading-[1.7]">
                        Latihan gesture tangan menggunakan kamera yang dianalisis oleh AI.
                    </p>
                </div>

                <!-- Card 3 - Riwayat Pembelajaran -->
                <div class="bg-white rounded-[18px] p-[30px_24px] text-center
                            shadow-[0_6px_22px_rgba(200,45,133,0.13)]
                            flex flex-col items-center justify-between
                            hover:-translate-y-[8px] hover:scale-[1.02]
                            hover:shadow-[0_18px_48px_rgba(250,150,200,0.65)] transition">
                    <div class="w-[80px] h-[80px] rounded-full bg-gradient-to-br from-blue-100 to-pink-100 flex items-center justify-center mb-4">
                        <svg class="w-[40px] h-[40px] text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-[1.2rem] font-semibold text-[#BE3B7A] mb-[12px]">
                        Riwayat Pembelajaran
                    </h3>
                    <p class="text-[0.95rem] text-[#492F48] leading-[1.7]">
                        Melihat skor dan perkembangan latihan sebelumnya.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="px-6 md:px-12 pb-[56px]">
        <div class="bg-[#FEF1F9] rounded-[28px] shadow-[0_6px_22px_rgba(200,45,133,0.13)] p-[52px_32px] text-center relative overflow-hidden hover:shadow-[0_18px_48px_rgba(250,150,200,0.65)] hover:-translate-y-[4px] transition">

            <div class="absolute w-[300px] h-[300px] border-[60px] border-[#F7DAED] rounded-full right-[-80px] top-[-80px] opacity-45"></div>

            <h2 class="text-[1.85rem] font-bold mb-[28px] relative z-10">
                Mulai Belajar Bahasa Isyarat Sekarang <span class="text-[#C82D85]">›</span>
            </h2>

            <div class="flex justify-center gap-[16px] flex-wrap relative z-10">
                <a href="{{ route('login') }}"
                   class="px-[32px] py-[14px] min-w-[180px] rounded-[18px] border-2 border-[#742958] text-[#742958] hover:bg-[#F7DAED] transition">
                    Masuk
                </a>

                <a href="{{ route('register') }}"
                   class="px-[32px] py-[14px] min-w-[180px] rounded-[18px] bg-[#C82D85] text-white hover:bg-[#951651] transition">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </section>

@include('layout.footer')
</div>
</body>
</html>
