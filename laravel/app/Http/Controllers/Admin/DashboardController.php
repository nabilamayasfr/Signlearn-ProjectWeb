<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Modul;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard'); // view di resources/views/dashboard.blade.php
    }

    public function data()
    {
        // Total Pengguna
        $totalUsers = User::count();

        // Pengguna Aktif
        $activeUsers = User::whereNotNull('email_verified_at')->count();

        // Total Modul
        $totalModuls = Modul::count();
        $bisindoCount = Modul::where('modul', 'BISINDO')->count();
        $sibiCount = Modul::where('modul', 'SIBI')->count();

        // Total Soal Kuis
        $totalSoal = QuizQuestion::count();

        // Total Level (distinct kombinasi language + level)
        $totalLevels = QuizQuestion::select('language', 'level')
            ->distinct()
            ->get()
            ->count();

        // Jumlah per level
        $levelPemula = QuizQuestion::where('level', 'pemula')->count();
        $levelMenengah = QuizQuestion::where('level', 'menengah')->count();
        $levelMahir = QuizQuestion::where('level', 'mahir')->count();

        // Pengguna terbaru (5 terakhir)
        $recentUsers = User::latest()->take(5)->get(['id', 'name', 'email']);

        // Modul terbaru (5 terakhir)
        $recentModuls = Modul::latest()->take(5)->get(['id', 'huruf', 'modul']);

        // Statistik per level
        $levelStats = [
            'pemula' => $levelPemula,
            'menengah' => $levelMenengah,
            'mahir' => $levelMahir,
        ];

        return response()->json([
            'total_users' => $totalUsers,
            'active_users' => $activeUsers,
            'total_moduls' => $totalModuls,
            'bisindo_count' => $bisindoCount,
            'sibi_count' => $sibiCount,
            'total_soal' => $totalSoal,
            'total_levels' => $totalLevels,
            'level_stats' => $levelStats,
            'recent_users' => $recentUsers,
            'recent_moduls' => $recentModuls,
        ]);
    }
}
