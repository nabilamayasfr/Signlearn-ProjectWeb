@extends('layout.app')
@section('title', 'SignLearn - Riwayat Belajar')
@section('content')
@include('layout.navbar')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
@endpush

<div class="min-h-screen font-[Poppins] bg-[linear-gradient(160deg,_#FFE8F4_0%,_#FFF0F8_40%,_#FDE6F2_100%)]">

  {{-- HEADER --}}
  <div class="px-12 pt-9 pb-0 max-[900px]:px-5 max-[900px]:pt-6">
    <div class="bg-white rounded-[22px] px-8 py-7 flex items-center justify-between
                shadow-[0_6px_28px_rgba(200,45,133,0.10)] border-[1.5px] border-[#F7DAED]
                mb-8 transition-all duration-300 hover:shadow-[0_14px_40px_rgba(200,45,133,0.16)]
                hover:-translate-y-0.5 max-[900px]:flex-col max-[900px]:text-center max-[900px]:gap-3.5">
      <div>
        <h1 class="text-[clamp(1.5rem,3vw,2rem)] font-extrabold text-[#C82D85] mb-1.5">Riwayat Belajarku</h1>
        <p class="text-[0.95rem] text-[#7A4B78] font-medium">Lihat semua latihan yang sudah kamu selesaikan</p>
      </div>
    </div>
  </div>

  {{-- STATISTIK RINGKASAN --}}
  @if($stats['total_kuis'] > 0 || $stats['total_praktik'] > 0)
  <div class="px-12 pb-6 max-[900px]:px-5">
    <div class="grid grid-cols-3 gap-3">
      <div class="bg-white rounded-[18px] px-4 py-4 text-center
                  shadow-[0_4px_16px_rgba(200,45,133,0.08)] border-[1.5px] border-[#F7DAED]">
        <div class="text-[1.8rem] font-black text-[#C82D85] leading-none mb-1">{{ $stats['total_kuis'] }}</div>
        <div class="text-[0.75rem] text-[#9B6898] font-semibold">Total Kuis</div>
      </div>
      <div class="bg-white rounded-[18px] px-4 py-4 text-center
                  shadow-[0_4px_16px_rgba(200,45,133,0.08)] border-[1.5px] border-[#F7DAED]">
        <div class="text-[1.8rem] font-black text-[#C82D85] leading-none mb-1">{{ $stats['total_praktik'] }}</div>
        <div class="text-[0.75rem] text-[#9B6898] font-semibold">Total Praktik</div>
      </div>
      <div class="bg-white rounded-[18px] px-4 py-4 text-center
                  shadow-[0_4px_16px_rgba(200,45,133,0.08)] border-[1.5px] border-[#F7DAED]">
        <div class="text-[1.8rem] font-black text-[#C82D85] leading-none mb-1">{{ $stats['praktik_berhasil'] }}</div>
        <div class="text-[0.75rem] text-[#9B6898] font-semibold">Praktik Berhasil</div>
      </div>
    </div>
  </div>
  @endif

  {{-- GRAFIK PERKEMBANGAN --}}
  @if($grafik->count() > 1)
  <div class="px-12 pb-6 max-[900px]:px-5">
    <div class="bg-white rounded-[22px] px-6 py-5
                shadow-[0_4px_18px_rgba(200,45,133,0.08)] border-[1.5px] border-[#F7DAED]">
      <p class="text-[1rem] font-extrabold text-[#492F48] mb-4">Perkembangan Skor (30 Hari Terakhir)</p>
      <div class="relative h-[200px]">
        <canvas id="grafik-skor"></canvas>
      </div>
    </div>
  </div>
  @endif

  {{-- AKTIVITAS --}}
  <section class="px-12 pb-9 max-[900px]:px-5">
    <p class="text-[1.35rem] font-extrabold text-[#492F48] mb-4">Aktivitas Terakhir</p>

    {{-- Filter Tabs --}}
    <div class="flex gap-2.5 mb-6 flex-wrap">
      <button class="filter-tab px-6 py-2 rounded-full text-[0.88rem] font-bold cursor-pointer border-none
                     transition-all duration-200 bg-[#C82D85] text-white shadow-[0_4px_14px_rgba(200,45,133,0.30)] active"
              onclick="filterTab('semua', this)">Semua</button>
      <button class="filter-tab px-6 py-2 rounded-full text-[0.88rem] font-bold cursor-pointer border-none
                     transition-all duration-200 bg-[#F7DAED] text-[#C82D85] hover:bg-[#F0B8D8]"
              onclick="filterTab('praktik', this)">Praktik Huruf</button>
      <button class="filter-tab px-6 py-2 rounded-full text-[0.88rem] font-bold cursor-pointer border-none
                     transition-all duration-200 bg-[#F7DAED] text-[#C82D85] hover:bg-[#F0B8D8]"
              onclick="filterTab('kuis', this)">Kuis Isyarat</button>
    </div>

    {{-- List --}}
    <div class="flex flex-col gap-3.5" id="riwayat-list">
      @forelse($riwayat as $item)

        @if($item['tipe'] === 'praktik')
        {{-- ── ITEM PRAKTIK ── --}}
        {{-- FIX: Satu div saja, onclick langsung di sini --}}
        <div class="riwayat-item bg-white rounded-[20px] px-[22px] py-[18px] flex items-center gap-4
                    shadow-[0_4px_18px_rgba(200,45,133,0.08)] border-[1.5px] border-[#F7DAED]
                    cursor-pointer transition-all duration-[220ms]
                    hover:-translate-y-[3px] hover:scale-[1.01] hover:shadow-[0_12px_32px_rgba(200,45,133,0.18)]"
             data-tipe="praktik"
             onclick="bukaPraktikDetail({{ json_encode($item) }})">

          <div class="w-[52px] h-[52px] rounded-[14px] shrink-0 flex items-center justify-center
                      bg-[linear-gradient(135deg,_#F1A2D0,_#C82D85)]
                      shadow-[0_3px_6px_rgba(200,45,133,0.25)]">
            <img src="/assets/icon-praktik.png" alt="Praktik" class="w-7 h-7 object-contain">
          </div>

          <div class="flex-1 min-w-0">
            <h3 class="text-[1rem] font-bold text-[#492F48] mb-[3px]">{{ $item['judul'] }}</h3>
            <span class="text-[0.83rem] text-[#9B6898] font-medium">{{ $item['subjudul'] }}</span>
          </div>

          <div class="flex items-center gap-1.5 shrink-0">
            <span class="px-3.5 py-1.5 rounded-full text-[0.82rem] font-bold
                         {{ ($item['status'] ?? '') === 'berhasil'
                            ? 'bg-[#E8F8EE] text-[#2D8B50]'
                            : 'bg-[#FFF8E8] text-[#B8860B]' }}">
              {{ $item['status_emoji'] ?? '' }} {{ $item['skor'] ?? 0 }}%
            </span>
          </div>
        </div>

        @else
        {{-- ── ITEM KUIS ── --}}
        <div class="riwayat-item bg-white rounded-[20px] px-[22px] py-[18px] flex items-center gap-4
                    shadow-[0_4px_18px_rgba(200,45,133,0.08)] border-[1.5px] border-[#F7DAED]
                    cursor-pointer transition-all duration-[220ms]
                    hover:-translate-y-[3px] hover:scale-[1.01] hover:shadow-[0_12px_32px_rgba(200,45,133,0.18)]"
             data-tipe="kuis"
             onclick="bukaKuis({{ json_encode($item) }})">

          <div class="w-[52px] h-[52px] rounded-[14px] shrink-0 flex items-center justify-center
                      bg-[linear-gradient(135deg,_#F1A2D0,_#C82D85)]
                      shadow-[0_3px_6px_rgba(200,45,133,0.25)]">
            <img src="/assets/icon-kuis.png" alt="Kuis" class="w-7 h-7 object-contain">
          </div>

          <div class="flex-1 min-w-0">
            <h3 class="text-[1rem] font-bold text-[#492F48] mb-[3px]">{{ $item['judul'] }}</h3>
            <span class="text-[0.83rem] text-[#9B6898] font-medium">{{ $item['subjudul'] }}</span>
          </div>

          <div class="flex items-center gap-1.5 shrink-0">
            <span class="px-3.5 py-1.5 rounded-full bg-[#C82D85] text-white text-[0.82rem] font-bold">
               {{ $item['benar'] }}
            </span>
            <span class="px-3.5 py-1.5 rounded-full bg-[#F7DAED] text-[#C82D85] text-[0.82rem] font-bold
                         border-[1.5px] border-[#F0B8D8]">
               {{ $item['salah'] }}
            </span>
          </div>
        </div>
        @endif

      @empty
        <div class="text-center py-16 px-6">
          <div class="text-[3rem] mb-3">📭</div>
          <p class="text-[1rem] font-bold text-[#492F48] mb-1">Belum ada riwayat belajar</p>
          <p class="text-[0.88rem] text-[#9B6898]">Yuk mulai latihan atau praktik pertamamu!</p>
          <a href="{{ route('latihan') }}"
             class="inline-block mt-4 px-6 py-2.5 rounded-full bg-[#C82D85] text-white
                    text-[0.88rem] font-bold no-underline mr-2">Mulai Latihan →</a>
          <a href="{{ route('pembelajaran') }}"
             class="inline-block mt-4 px-6 py-2.5 rounded-full bg-[#2D85C8] text-white
                    text-[0.88rem] font-bold no-underline">Mulai Praktik →</a>
        </div>
      @endforelse
    </div>{{-- tutup #riwayat-list --}}

    {{-- Load More --}}
    @if($next_page)
    <div class="text-center mt-6" id="load-more-wrapper">
      <button id="btn-load-more"
              onclick="loadMore()"
              data-next="{{ $next_page }}"
              class="px-8 py-3 rounded-full bg-white border-2 border-[#C82D85]
                     text-[#C82D85] text-[0.9rem] font-bold transition-all duration-200
                     hover:bg-[#C82D85] hover:text-white hover:shadow-[0_6px_20px_rgba(200,45,133,0.30)]">
        Muat Lebih Banyak
      </button>
    </div>
    @endif

    <div class="text-center py-12 px-6 hidden" id="empty-filter">
      <img src="{{ asset('assets/icon-empty.png') }}" alt="Kosong"
           class="w-14 h-14 object-contain mx-auto mb-3 block opacity-60"
           onerror="this.style.display='none'">
      <p class="text-[0.95rem] font-medium text-[#9B6898]">Tidak ada riwayat untuk kategori ini.</p>
    </div>
  </section>

  @include('layout.footer')
</div>

<div id="modal-praktik"
     class="fixed inset-0 z-[999] hidden items-center justify-center p-4"
     style="background: rgba(73,47,72,0.52); backdrop-filter: blur(5px);"
     onclick="tutupOverlay('modal-praktik', event)">

  <div class="bg-white rounded-[26px] w-full max-w-[480px] shadow-[0_24px_70px_rgba(200,45,133,0.25)]
              overflow-hidden flex flex-col max-h-[90vh]">

    {{-- Header --}}
    <div class="bg-[linear-gradient(135deg,_#F1A2D0_0%,_#C82D85_100%)] px-6 py-[22px]
                flex items-center justify-between gap-3 shrink-0">
      <div class="flex items-center gap-3.5">
        <div class="w-12 h-12 rounded-xl bg-[rgba(255,255,255,0.22)] p-[5px] shrink-0
                    flex items-center justify-center">
          <img src="/assets/icon-praktik.png" alt="Praktik" class="w-8 h-8 object-contain">
        </div>
        <div>
          <h2 class="text-[1.05rem] font-extrabold text-white mb-0.5" id="pd-judul">Praktik Huruf</h2>
          <span class="text-[0.82rem] text-[rgba(255,255,255,0.88)] font-medium" id="pd-tanggal">—</span>
        </div>
      </div>
      <button class="w-8 h-8 rounded-full bg-[rgba(255,255,255,0.22)] border-none cursor-pointer
                     flex items-center justify-center text-[15px] text-white font-bold
                     transition-colors duration-200 hover:bg-[rgba(255,255,255,0.38)] shrink-0"
              onclick="tutupModal('modal-praktik')">✕</button>
    </div>

    {{-- Body --}}
    <div class="px-6 py-[22px] overflow-y-auto flex-1">

      {{-- Skor besar --}}
      <div class="text-center mb-5">
        <div class="text-[3.5rem] font-black leading-none mb-2 text-[#C82D85]" id="pd-skor">—</div>
        <div class="inline-block px-4 py-1 rounded-full text-sm font-bold" id="pd-status-badge">—</div>
      </div>

      {{-- Info Grid --}}
      <div class="grid grid-cols-2 gap-3 mb-5">
        <div class="bg-[#FEF0F8] rounded-[14px] p-3 text-center border border-[#F7DAED]">
          <p class="text-[0.7rem] text-[#9B6898] font-medium mb-0.5">Huruf</p>
          <p id="pd-huruf" class="text-[1.8rem] font-black text-[#C82D85] leading-none">—</p>
        </div>
        <div class="bg-[#FEF0F8] rounded-[14px] p-3 text-center border border-[#F7DAED]">
          <p class="text-[0.7rem] text-[#9B6898] font-medium mb-0.5">Bahasa</p>
          <p id="pd-bahasa" class="text-[1.1rem] font-black text-[#492F48]">—</p>
        </div>
      </div>

      {{-- Detail info: hanya Tanggal & Durasi --}}
      <div class="flex flex-col gap-2 mb-5">
        <div class="flex items-center justify-between px-3.5 py-2.5 bg-[#FEF8FC] rounded-xl border border-[#F7DAED]">
          <span class="text-[0.83rem] text-[#7A4B78] font-semibold"> Tanggal</span>
          <span class="text-[0.86rem] text-[#492F48] font-bold" id="pd-tanggal-detail">—</span>
        </div>
        <div class="flex items-center justify-between px-3.5 py-2.5 bg-[#FEF8FC] rounded-xl border border-[#F7DAED]">
          <span class="text-[0.83rem] text-[#7A4B78] font-semibold"> Durasi</span>
          <span class="text-[0.86rem] text-[#492F48] font-bold" id="pd-durasi">—</span>
        </div>
      </div>

      {{-- Tombol Aksi --}}
      <div class="flex flex-col gap-2">
        <a id="pd-btn-ulangi" href="#"
           class="w-full py-3 rounded-[14px] text-white text-[0.9rem] font-bold
                  text-center transition hover:opacity-90 no-underline
                  bg-[linear-gradient(135deg,_#F1A2D0,_#C82D85)]">
          Ulangi Praktik Huruf Ini
        </a>
        <a href="{{ route('pembelajaran.index') }}"
           class="w-full py-3 rounded-[14px] text-[#C82D85] text-[0.9rem] font-bold
                  text-center border-2 border-[#F7DAED] transition hover:bg-[#FEF0F8] no-underline">
          Ke Halaman Pembelajaran
        </a>
      </div>

    </div>
  </div>
</div>

{{-- ══════════════════════════════
     MODAL KUIS ISYARAT
══════════════════════════════ --}}
<div id="modal-kuis"
     class="fixed inset-0 z-[999] hidden items-center justify-center p-4"
     style="background: rgba(73,47,72,0.52); backdrop-filter: blur(5px);"
     onclick="tutupOverlay('modal-kuis', event)">

  <div class="bg-white rounded-[26px] w-full max-w-[520px] shadow-[0_24px_70px_rgba(200,45,133,0.25)]
              overflow-hidden flex flex-col max-h-[90vh]">

    <div class="bg-[linear-gradient(135deg,_#F1A2D0_0%,_#C82D85_100%)] px-6 py-[22px]
                flex items-center justify-between gap-3 shrink-0">
      <div class="flex items-center gap-3.5">
        <div class="w-12 h-12 rounded-xl bg-[rgba(255,255,255,0.22)] p-[5px] shrink-0
                    flex items-center justify-center">
          <img src="/assets/icon-kuis.png" alt="Kuis" class="w-8 h-8 object-contain">
        </div>
        <div>
          <h2 class="text-[1.05rem] font-extrabold text-white mb-0.5" id="k-judul">Kuis Isyarat</h2>
          <span class="text-[0.82rem] text-[rgba(255,255,255,0.88)] font-medium" id="k-subjudul"></span>
        </div>
      </div>
      <button class="w-8 h-8 rounded-full bg-[rgba(255,255,255,0.22)] border-none cursor-pointer
                     flex items-center justify-center text-[15px] text-white font-bold
                     transition-colors duration-200 hover:bg-[rgba(255,255,255,0.38)] shrink-0"
              onclick="tutupModal('modal-kuis')"></button>
    </div>

    <div class="px-6 py-[22px] overflow-y-auto flex-1">

      {{-- Skor besar --}}
      <div class="text-center px-5 py-[18px] bg-[#FEF0F8] rounded-2xl mb-4 border-[1.5px] border-[#F7DAED]">
        <p class="text-[0.75rem] text-[#9B6898] font-bold uppercase tracking-[0.6px] mb-[3px]">Skor Kuis</p>
        <div class="text-[2.6rem] font-black text-[#C82D85] leading-none mb-[3px]" id="k-skor">—</div>
        <p class="text-[0.82rem] text-[#7A4B78] font-medium" id="k-skor-sub">—</p>
      </div>

      {{-- Stat benar / salah --}}
      <div class="grid grid-cols-2 gap-2.5 mb-4">
        <div class="rounded-xl border border-[#B8E8C8] p-3 text-center bg-[#E8F8EE]">
          <div class="text-[1.5rem] font-black leading-none mb-1 text-[#2D8B50]" id="k-benar"></div>
          <span class="text-[0.78rem] font-semibold text-[#7A4B78]">Jawaban Benar</span>
        </div>
        <div class="rounded-xl border border-[#F0BBBB] p-3 text-center bg-[#FDECEC]">
          <div class="text-[1.5rem] font-black leading-none mb-1 text-[#B22020]" id="k-salah"></div>
          <span class="text-[0.78rem] font-semibold text-[#7A4B78]">Jawaban Salah</span>
        </div>
      </div>

      {{-- Detail info --}}
      <div class="flex flex-col gap-2 mb-4">
        <div class="flex items-center justify-between px-3.5 py-2.5 bg-[#FEF8FC] rounded-xl border border-[#F7DAED]">
          <span class="text-[0.83rem] text-[#7A4B78] font-semibold"> Tanggal</span>
          <span class="text-[0.86rem] text-[#492F48] font-bold text-right" id="k-tanggal">—</span>
        </div>
        <div class="flex items-center justify-between px-3.5 py-2.5 bg-[#FEF8FC] rounded-xl border border-[#F7DAED]">
          <span class="text-[0.83rem] text-[#7A4B78] font-semibold"> Durasi</span>
          <span class="text-[0.86rem] text-[#492F48] font-bold text-right" id="k-durasi">—</span>
        </div>
      </div>

      {{-- Daftar soal --}}
      <p class="text-[0.8rem] font-bold text-[#C82D85] uppercase tracking-[0.5px] mb-2.5">
         Kumpulan Soal yang Dikerjakan
      </p>
      <div class="flex flex-col gap-2.5 mb-4" id="k-soal-list"></div>

      <a href="{{ route('latihan') }}"
         class="block w-full py-3.5 rounded-2xl bg-[#C82D85] text-white text-[0.93rem] font-extrabold
                text-center border-none cursor-pointer shadow-[0_6px_20px_rgba(200,45,133,0.32)]
                transition-all duration-200 no-underline
                hover:bg-[#951651] hover:-translate-y-0.5 hover:shadow-[0_10px_28px_rgba(200,45,133,0.42)]">
        Ulangi Kuis
      </a>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// ── GRAFIK PERKEMBANGAN ──────────────────────────────────────
(function () {
  const canvas = document.getElementById('grafik-skor');
  if (!canvas) return;

  const grafikRaw = @json($grafik);
  const labels = grafikRaw.map(d => d.tanggal + ' (' + d.label + ')');
  const scores = grafikRaw.map(d => d.skor);
  const pointColors = scores.map(s =>
    s >= 80 ? '#5CB87A' : s >= 60 ? '#E8C87A' : '#E57373'
  );

  new Chart(canvas, {
    type: 'line',
    data: {
      labels,
      datasets: [{
        label: 'Skor (%)',
        data: scores,
        borderColor: '#C82D85',
        backgroundColor: 'rgba(200, 45, 133, 0.08)',
        borderWidth: 2.5,
        pointBackgroundColor: pointColors,
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointRadius: 6,
        pointHoverRadius: 8,
        fill: true,
        tension: 0.4,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#492F48',
          titleColor: '#fff',
          bodyColor: 'rgba(255,255,255,0.85)',
          padding: 10,
          callbacks: { label: ctx => ' Skor: ' + ctx.raw + '%' }
        }
      },
      scales: {
        y: {
          min: 0, max: 100,
          ticks: { stepSize: 20, callback: v => v + '%', color: '#9B6898', font: { size: 11, family: 'Poppins' } },
          grid: { color: 'rgba(200,45,133,0.07)' }
        },
        x: {
          ticks: { color: '#9B6898', font: { size: 10, family: 'Poppins' }, maxRotation: 45 },
          grid: { display: false }
        }
      }
    }
  });
})();

// ── FILTER ───────────────────────────────────────────────────
function filterTab(tipe, el) {
  document.querySelectorAll('.filter-tab').forEach(t => {
    t.classList.remove('bg-[#C82D85]', 'text-white', 'shadow-[0_4px_14px_rgba(200,45,133,0.30)]');
    t.classList.add('bg-[#F7DAED]', 'text-[#C82D85]');
  });
  el.classList.add('bg-[#C82D85]', 'text-white', 'shadow-[0_4px_14px_rgba(200,45,133,0.30)]');
  el.classList.remove('bg-[#F7DAED]', 'text-[#C82D85]');

  let visible = 0;
  document.querySelectorAll('.riwayat-item').forEach(item => {
    const show = tipe === 'semua' || item.dataset.tipe === tipe;
    item.style.display = show ? 'flex' : 'none';
    if (show) visible++;
  });
  const emptyFilter = document.getElementById('empty-filter');
  emptyFilter.classList.toggle('hidden', visible !== 0);
  emptyFilter.classList.toggle('block',  visible === 0);
}

// ── LOAD MORE ────────────────────────────────────────────────
async function loadMore() {
  const btn      = document.getElementById('btn-load-more');
  const nextPage = btn.dataset.next;
  btn.textContent = 'Memuat...';
  btn.disabled    = true;

  try {
    const res  = await fetch(nextPage, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
    const data = await res.json();
    document.getElementById('riwayat-list').insertAdjacentHTML('beforeend', data.html);

    if (data.next_page) {
      btn.dataset.next = data.next_page;
      btn.textContent  = 'Muat Lebih Banyak';
      btn.disabled     = false;
    } else {
      document.getElementById('load-more-wrapper').remove();
    }
  } catch (err) {
    console.error('Gagal load more:', err);
    btn.textContent = 'Gagal, coba lagi';
    btn.disabled    = false;
  }
}

// ── MODAL PRAKTIK ────────────────────────────────────────────
function bukaPraktikDetail(item) {
  document.getElementById('pd-judul').textContent          = item.judul ?? 'Praktik Huruf';
  document.getElementById('pd-tanggal').textContent        = item.tanggal ?? '—';
  document.getElementById('pd-tanggal-detail').textContent = item.tanggal ?? '—';
  document.getElementById('pd-skor').textContent           = (item.skor != null ? item.skor + '%' : '—');
  document.getElementById('pd-huruf').textContent          = item.huruf ?? '?';
  document.getElementById('pd-bahasa').textContent         = item.bahasa ?? item.kategori ?? '—';

  // Durasi: coba berbagai key yang mungkin dikirim dari backend
  const durasi = item.durasi ?? item.waktu ?? item.duration ?? null;
  document.getElementById('pd-durasi').textContent =
    durasi ? durasi : 'Tidak tercatat';

  // Status badge
  const badge = document.getElementById('pd-status-badge');
  if ((item.status ?? '') === 'berhasil') {
    badge.textContent = ' Berhasil';
    badge.className   = 'inline-block px-4 py-1 rounded-full text-sm font-bold bg-[#E8F8EE] text-[#2D8B50]';
  } else {
    badge.textContent = ' Perlu Latihan';
    badge.className   = 'inline-block px-4 py-1 rounded-full text-sm font-bold bg-[#FFF8E8] text-[#B8860B]';
  }

  // Link tombol ulangi
  const bahasa = (item.bahasa ?? 'bisindo').toLowerCase();
  const huruf  = (item.huruf  ?? 'a').toLowerCase();
  document.getElementById('pd-btn-ulangi').href = '/pembelajaran/' + bahasa + '/' + huruf;

  bukaOverlay('modal-praktik');
}

// ── MODAL KUIS ───────────────────────────────────────────────
function bukaKuis(data) {
  document.getElementById('k-judul').textContent    = data.judul    ?? 'Kuis Isyarat';
  document.getElementById('k-subjudul').textContent = data.subjudul ?? '—';

  const skor  = data.skor  ?? 0;
  const benar = data.benar ?? 0;
  const salah = data.salah ?? 0;
  const total = data.total_soal ?? (benar + salah);

  document.getElementById('k-skor').textContent     = skor + '%';
  document.getElementById('k-skor-sub').textContent = benar + ' benar dari ' + total + ' soal';
  document.getElementById('k-benar').textContent    = benar;
  document.getElementById('k-salah').textContent    = salah;
  document.getElementById('k-tanggal').textContent  = data.tanggal ?? '—';

  const durasiKuis = data.durasi ?? data.waktu ?? data.duration ?? null;
  document.getElementById('k-durasi').textContent   = durasiKuis ? durasiKuis : 'Tidak tercatat';

  // Render daftar soal
  const list     = document.getElementById('k-soal-list');
  list.innerHTML = '';
  const soalList = data.soal_detail ?? [];

  soalList.forEach(s => {
    const benarSoal  = s.benar;
    const headerBg   = benarSoal ? 'bg-[#E8F8EE] border-b border-[#B8E8C8]' : 'bg-[#FDECEC] border-b border-[#F0BBBB]';
    const nomorBg    = benarSoal ? 'bg-[#5CB87A]' : 'bg-[#E57373]';

    let pilihanHTML = '';
    const pilihan   = s.pilihan ?? [];

    pilihan.forEach(p => {
      const isBenar = p === s.jawaban_benar;
      const isUser  = p === s.jawaban_user;
      let rowCls, dotCls, dotInner = '';

      if (isBenar) {
        rowCls   = 'flex items-center gap-1.5 text-[0.82rem] font-semibold py-1 text-[#2D8B50]';
        dotCls   = 'w-4 h-4 rounded-full shrink-0 flex items-center justify-center bg-[#5CB87A] border-[1.5px] border-[#5CB87A] text-[9px] text-white font-black';
        dotInner = '✓';
      } else if (isUser && !benarSoal) {
        rowCls   = 'flex items-center gap-1.5 text-[0.82rem] font-semibold py-1 text-[#B22020]';
        dotCls   = 'w-4 h-4 rounded-full shrink-0 flex items-center justify-center bg-[#E57373] border-[1.5px] border-[#E57373] text-[9px] text-white font-black';
        dotInner = '✕';
      } else {
        rowCls  = 'flex items-center gap-1.5 text-[0.82rem] font-semibold py-1 text-[#9B6898]';
        dotCls  = 'w-4 h-4 rounded-full border-[1.5px] border-[#D8A8CE] shrink-0 flex items-center justify-center';
      }

      const extra = isUser && isBenar    ? ' ✓ (jawaban kamu, benar!)'
                  : isUser && !benarSoal ? ' (jawaban kamu)'
                  : isBenar && !benarSoal ? ' ← jawaban benar'
                  : '';

      pilihanHTML += `<div class="${rowCls}"><div class="${dotCls}">${dotInner}</div>${p}${extra}</div>`;
    });

    if (pilihan.length === 0) {
      pilihanHTML = `<p class="text-[0.82rem] text-[#9B6898]">Jawaban kamu: <strong>${s.jawaban_user}</strong> | Benar: <strong>${s.jawaban_benar}</strong></p>`;
    }

    const card = document.createElement('div');
    card.className = 'rounded-2xl border-[1.5px] border-[#F7DAED] overflow-hidden bg-white';
    card.innerHTML = `
      <div class="flex items-center gap-2.5 px-3.5 py-2.5 ${headerBg}">
        <div class="w-7 h-7 rounded-full flex items-center justify-center text-[0.78rem] font-extrabold shrink-0 text-white ${nomorBg}">${s.nomor}</div>
        <span class="text-[0.85rem] font-semibold text-[#492F48] flex-1">${s.soal}</span>
        <span class="text-[1rem]">${statusIcon}</span>
      </div>
      <div class="px-3.5 py-2.5 flex gap-3 items-start">
        <img src="/${s.img}" alt="Soal ${s.nomor}"
             class="w-[60px] h-[60px] object-contain rounded-[10px] bg-[#FEF0F8] border-[1.5px] border-[#F7DAED] shrink-0 p-1"
             onerror="this.style.opacity='0.3'">
        <div class="flex-1">${pilihanHTML}</div>
      </div>`;
    list.appendChild(card);
  });

  if (soalList.length === 0) {
    list.innerHTML = '<p class="text-[#9B6898] text-[0.88rem] text-center py-3">Detail soal tidak tersedia.</p>';
  }

  bukaOverlay('modal-kuis');
}

// ── HELPER MODAL ─────────────────────────────────────────────
function bukaOverlay(id) {
  const el = document.getElementById(id);
  el.classList.remove('hidden');
  el.classList.add('flex');
  document.body.style.overflow = 'hidden';
}

function tutupModal(id) {
  const el = document.getElementById(id);
  el.classList.add('hidden');
  el.classList.remove('flex');
  document.body.style.overflow = '';
}

function tutupOverlay(id, e) {
  if (e.target === document.getElementById(id)) tutupModal(id);
}

// Tutup modal dengan Escape
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') ['modal-praktik', 'modal-kuis'].forEach(id => tutupModal(id));
});
</script>
@endpush

@endsection
