<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PraktikResult;

class PraktikController extends Controller
{
    public function show($modul, $huruf)
    {
        $modulValid = ['bisindo', 'sibi'];
        if (!in_array(strtolower($modul), $modulValid)) {
            abort(404);
        }

        $hurufUpper = strtoupper($huruf);
        if (!preg_match('/^[A-Z]$/', $hurufUpper)) {
            abort(404);
        }

        return view('huruf', [
            'modul' => strtolower($modul),
            'huruf' => $hurufUpper,
        ]);
    }

    public function simpan(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Belum login'], 401);
        }

        $request->validate([
            'language'         => 'required|in:bisindo,sibi',
            'huruf'            => 'required|string|size:1|regex:/^[A-Za-z]$/',
            'skor_ai'          => 'required|numeric|min:0|max:1',
            'prediksi_ai'      => 'nullable|string|size:1',
            'duration_seconds' => 'nullable|integer|min:1|max:30', // ← TAMBAHAN validasi
        ]);

        $status = $request->skor_ai >= 0.80 ? 'berhasil' : 'perlu_latihan';

        $hasil = PraktikResult::create([
            'user_id'          => Auth::id(),
            'language'         => strtolower($request->language),
            'huruf'            => strtoupper($request->huruf),
            'skor_ai'          => $request->skor_ai,
            'status'           => $status,
            'prediksi_ai'      => $request->prediksi_ai
                                  ? strtoupper($request->prediksi_ai)
                                  : null,
            'duration_seconds' => $request->duration_seconds, 
        ]);

        return response()->json([
            'message'     => 'Hasil praktik berhasil disimpan',
            'status'      => $status,
            'skor_persen' => (int) round($request->skor_ai * 100),
        ]);
    }

    public function riwayatHuruf($modul, $huruf)
    {
        if (!Auth::check()) {
            return response()->json([]);
        }

        $riwayat = PraktikResult::where('user_id',  Auth::id())
            ->where('language', strtolower($modul))
            ->where('huruf',    strtoupper($huruf))
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($r) => [
                'skor_persen' => $r->skor_persen,
                'status'      => $r->status_label,
                'tanggal'     => $r->created_at->locale('id')->isoFormat('D MMM YYYY, HH:mm'),
            ]);

        return response()->json($riwayat);
    }
}