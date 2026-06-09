<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PraktikResult;

class BerandaController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Hitung huruf yang sudah pernah BERHASIL dipraktikkan
        // Total 52: 26 huruf BISINDO + 26 huruf SIBI
        // Kita hitung kombinasi unik bahasa+huruf
        $hurufDikuasai = PraktikResult::where('user_id', $userId)
            ->where('status', 'berhasil')
            ->select('language', 'huruf')
            ->distinct()
            ->get();

        $mastered = $hurufDikuasai->count();
        $total    = 52;
        $pct      = $total > 0 ? round(($mastered / $total) * 100) : 0;

        $userProgress = (object)[
            'mastered' => $mastered,
            'total'    => $total,
            'pct'      => $pct,
        ];

        return view('beranda', compact('userProgress'));
    }
}