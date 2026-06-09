<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizResult;
use App\Models\QuizQuestion;
use App\Models\PraktikResult;
use Illuminate\Support\Facades\Auth;

class HistoriController extends Controller
{
    const PER_PAGE = 10;

    public function index()
    {
        $userId = Auth::id();

        // ══ KUIS: ambil dengan pagination ══
        $hasilKuis = QuizResult::where('user_id', $userId)
                               ->latest()
                               ->paginate(self::PER_PAGE);

        // Fix N+1 untuk soal kuis
        $semuaQuestionIds = $hasilKuis->getCollection()
            ->flatMap(fn($r) => $r->answers_detail
                ? collect($r->answers_detail)->pluck('question_id')->filter()
                : [])
            ->unique()->values()->toArray();

        $soalCache = QuizQuestion::whereIn('id', $semuaQuestionIds)
                                 ->get()->keyBy('id');

        $riwayatKuis = $hasilKuis->getCollection()->map(
            fn($r) => $this->formatHasilKuis($r, $soalCache)
        );

        // ══ PRAKTIK: ambil semua (sudah ringan, hanya 1 baris per sesi) ══
        $hasilPraktik  = PraktikResult::where('user_id', $userId)
                                      ->latest()
                                      ->get();

        $riwayatPraktik = $hasilPraktik->map(
            fn($r) => $this->formatHasilPraktik($r)
        );

        // ══ GABUNGKAN dan urutkan dari terbaru ══
        $riwayat = $riwayatKuis->concat($riwayatPraktik)
                               ->sortByDesc('created_at_raw')
                               ->values();

        // ══ STATISTIK ══
        $allKuis    = QuizResult::where('user_id', $userId)->get();
        $allPraktik = PraktikResult::where('user_id', $userId)->get();

        $stats = [
            'total_kuis'        => $allKuis->count(),
            'rata_skor'         => $allKuis->count() > 0
                                   ? round($allKuis->avg('score_percentage')) : 0,
            'skor_terbaik'      => $allKuis->count() > 0
                                   ? $allKuis->max('score_percentage') : 0,
            'total_praktik'     => $allPraktik->count(),
            'rata_skor_praktik' => $allPraktik->count() > 0
                                   ? round($allPraktik->avg('skor_ai') * 100) : 0,
            'praktik_berhasil'  => $allPraktik->where('status', 'berhasil')->count(),
        ];

        // ══ GRAFIK: gabungkan kuis + praktik 30 hari terakhir ══
        $grafikKuis = QuizResult::where('user_id', $userId)
            ->where('created_at', '>=', now()->subDays(30))
            ->latest()->get()
            ->map(fn($r) => [
                'tanggal' => $r->created_at->format('d/m'),
                'skor'    => $r->score_percentage,
                'tipe'    => 'Kuis',
                'label'   => strtoupper($r->language),
            ]);

        $grafikPraktik = PraktikResult::where('user_id', $userId)
            ->where('created_at', '>=', now()->subDays(30))
            ->latest()->get()
            ->map(fn($r) => [
                'tanggal' => $r->created_at->format('d/m'),
                'skor'    => (int) round($r->skor_ai * 100),
                'tipe'    => 'Praktik',
                'label'   => strtoupper($r->language) . ' ' . $r->huruf,
            ]);

        $grafikData = $grafikKuis->concat($grafikPraktik)
                                 ->sortBy(fn($d) => $d['tanggal'])
                                 ->values();

        if (request()->ajax()) {
            return response()->json([
                'html'      => view('partials.riwayat-items', compact('riwayat'))->render(),
                'next_page' => $hasilKuis->nextPageUrl(),
            ]);
        }

        return view('histori', [
            'riwayat'   => $riwayat,
            'stats'     => $stats,
            'next_page' => $hasilKuis->nextPageUrl(),
            'grafik'    => $grafikData,
        ]);
    }

    // ── Format data kuis untuk tampilan ──
    private function formatHasilKuis(QuizResult $result, $soalCache = null): array
    {
        $bahasa     = strtoupper($result->language);
        $levelLabel = ucfirst($result->level);
        $benar      = $result->correct_answers;
        $salah      = $result->total_questions - $benar;

        $soalDetail = [];
        if ($result->answers_detail) {
            foreach ($result->answers_detail as $idx => $ans) {
                $soalDetail[] = [
                    'nomor'         => $idx + 1,
                    'soal'          => 'Huruf apa yang ditunjukkan gerakan ini?',
                    'img'           => ltrim(parse_url($ans['image_url'] ?? '', PHP_URL_PATH), '/'),
                    'jawaban_benar' => $ans['correct_answer'] ?? '',
                    'jawaban_user'  => $ans['user_answer']    ?? '',
                    'benar'         => $ans['is_correct']     ?? false,
                    'pilihan'       => $this->getPilihanFromCache($ans, $soalCache),
                ];
            }
        }

        return [
            'tipe'           => 'kuis',
            'judul'          => 'Kuis ' . $bahasa,
            'subjudul'       => 'Level ' . $levelLabel . ' · ' . $result->created_at->locale('id')->isoFormat('D MMM YYYY'),
            'skor'           => $result->score_percentage,
            'benar'          => $benar,
            'salah'          => $salah,
            'total_soal'     => $result->total_questions,
            'tanggal'        => $result->created_at->locale('id')->isoFormat('D MMMM YYYY, HH:mm'),
            // FIX: format durasi lebih natural, tanpa "menit" redundan di belakang mm:ss
            'durasi'         => $this->formatDurasi($result->duration_seconds ?? null),
            'kategori'       => $bahasa,
            'level'          => $levelLabel,
            'soal_detail'    => $soalDetail,
            'created_at_raw' => $result->created_at->timestamp,
        ];
    }

    // ── Format data praktik untuk tampilan ──
    private function formatHasilPraktik(PraktikResult $result): array
    {
        $bahasa      = strtoupper($result->language);
        $skorPersen  = (int) round($result->skor_ai * 100);
        $statusLabel = $result->status === 'berhasil' ? 'Berhasil' : 'Perlu Latihan';

        return [
            'tipe'           => 'praktik',
            'judul'          => 'Praktik ' . $bahasa . ' — Huruf ' . $result->huruf,
            'subjudul'       => $statusLabel . ' · ' . $result->created_at->locale('id')->isoFormat('D MMM YYYY'),
            'skor'           => $skorPersen,
            'huruf'          => $result->huruf,
            'bahasa'         => $bahasa,
            'status'         => $result->status,
            'status_label'   => $statusLabel,
            'prediksi_ai'    => $result->prediksi_ai,
            'tanggal'        => $result->created_at->locale('id')->isoFormat('D MMMM YYYY, HH:mm'),
            // FIX: tambahkan durasi — coba kolom duration_seconds, fallback ke null
            'durasi'         => $this->formatDurasi($result->duration_seconds ?? null),
            'created_at_raw' => $result->created_at->timestamp,
        ];
    }

    /**
     * Format detik jadi string yang mudah dibaca.
     * Contoh: 90 → "1 menit 30 detik", 45 → "45 detik", null → "Tidak tercatat"
     */
    private function formatDurasi(?int $detik): string
    {
        if (!$detik || $detik <= 0) {
            return 'Tidak tercatat';
        }

        $menit = intdiv($detik, 60);
        $sisa  = $detik % 60;

        if ($menit > 0 && $sisa > 0) {
            return $menit . ' menit ' . $sisa . ' detik';
        } elseif ($menit > 0) {
            return $menit . ' menit';
        } else {
            return $sisa . ' detik';
        }
    }

    private function getPilihanFromCache(array $ans, $soalCache = null): array
    {
        if ($soalCache && !empty($ans['question_id'])) {
            $soal = $soalCache->get($ans['question_id']);
            if ($soal) return $soal->options;
        }
        $pilihan = [$ans['correct_answer'] ?? ''];
        if (isset($ans['user_answer']) && $ans['user_answer'] !== $ans['correct_answer']) {
            $pilihan[] = $ans['user_answer'];
        }
        return array_unique($pilihan);
    }
}