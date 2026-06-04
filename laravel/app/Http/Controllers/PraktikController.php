<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PraktikResult;

class PraktikController extends Controller
{
    /**
     * Halaman praktik — user menghadap kamera dan melakukan gesture.
     * URL: GET /pembelajaran/{modul}/{huruf}
     *
     * Contoh: /pembelajaran/bisindo/c
     */
    public function show($modul, $huruf)
    {
        // Validasi modul
        $modulValid = ['bisindo', 'sibi'];
        if (!in_array(strtolower($modul), $modulValid)) {
            abort(404);
        }

        // Validasi huruf A-Z
        $hurufUpper = strtoupper($huruf);
        if (!preg_match('/^[A-Z]$/', $hurufUpper)) {
            abort(404);
        }

        return view('huruf', [
            'modul' => strtolower($modul),
            'huruf' => $hurufUpper,
        ]);
    }

    /**
     * API endpoint: simpan hasil praktik AI ke database.
     * Dipanggil dari JavaScript di halaman huruf setelah AI selesai mendeteksi.
     *
     * URL: POST /praktik/simpan
     *
     * Request body (JSON):
     * {
     *   "language":    "bisindo",
     *   "huruf":       "C",
     *   "skor_ai":     0.92,      ← confidence dari FastAPI (0.0 - 1.0)
     *   "prediksi_ai": "C"        ← prediction dari FastAPI
     * }
     */
    public function simpan(Request $request)
    {
        // Hanya user yang login yang bisa menyimpan
        if (!Auth::check()) {
            return response()->json(['message' => 'Belum login'], 401);
        }

        $request->validate([
            'language'    => 'required|in:bisindo,sibi',
            'huruf'       => 'required|string|size:1|regex:/^[A-Za-z]$/',
            'skor_ai'     => 'required|numeric|min:0|max:1',
            'prediksi_ai' => 'nullable|string|size:1',
        ]);

        // Tentukan status berdasarkan skor
        // Threshold: 80% ke atas = berhasil
        $status = $request->skor_ai >= 0.80 ? 'berhasil' : 'perlu_latihan';

        $hasil = PraktikResult::create([
            'user_id'     => Auth::id(),
            'language'    => strtolower($request->language),
            'huruf'       => strtoupper($request->huruf),
            'skor_ai'     => $request->skor_ai,
            'status'      => $status,
            'prediksi_ai' => $request->prediksi_ai
                             ? strtoupper($request->prediksi_ai)
                             : null,
        ]);

        return response()->json([
            'message'    => 'Hasil praktik berhasil disimpan',
            'status'     => $status,
            'skor_persen' => (int) round($request->skor_ai * 100),
        ]);
    }

    /**
     * API endpoint: ambil riwayat praktik user untuk huruf tertentu.
     * Berguna untuk tampilkan progress per huruf di halaman praktik.
     *
     * URL: GET /praktik/riwayat/{modul}/{huruf}
     */
    public function riwayatHuruf($modul, $huruf)
    {
        if (!Auth::check()) {
            return response()->json([]);
        }

        $riwayat = PraktikResult::where('user_id',  Auth::id())
            ->where('language', strtolower($modul))
            ->where('huruf',    strtoupper($huruf))
            ->latest()
            ->take(5)  // 5 percobaan terakhir untuk huruf ini
            ->get()
            ->map(fn($r) => [
                'skor_persen' => $r->skor_persen,
                'status'      => $r->status_label,
                'tanggal'     => $r->created_at->locale('id')->isoFormat('D MMM YYYY, HH:mm'),
            ]);

        return response()->json($riwayat);
    }
}