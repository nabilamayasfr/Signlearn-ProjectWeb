<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Modul;
use App\Models\UserProgress;

class PembelajaranController extends Controller
{
    /**
     * Halaman utama pembelajaran
     * Menampilkan semua huruf BISINDO dan SIBI
     */
    public function index()
    {
        $bisindo = Modul::where('modul', 'BISINDO')
            ->orderBy('huruf', 'asc')
            ->get();

        $sibi = Modul::where('modul', 'SIBI')
            ->orderBy('huruf', 'asc')
            ->get();

        return view('pembelajaran', compact('bisindo', 'sibi'));
    }

    /**
     * Halaman detail huruf
     * Contoh URL:
     * /pembelajaran/bisindo/A
     * /pembelajaran/sibi/C
     */
    public function showHuruf($modul, $huruf)
    {
        $dataModul = Modul::where('modul', strtoupper($modul))
            ->where('huruf', strtoupper($huruf))
            ->firstOrFail();

        return view('detail', [
            'dataModul' => $dataModul,
            'modul'     => strtoupper($modul),
            'huruf'     => strtoupper($huruf),
        ]);
    }

    /**
     * GET /pembelajaran/progress?module=BISINDO
     * Ambil daftar huruf yang sudah dikuasai user untuk modul tertentu
     */
    public function getProgress(Request $request)
    {
        $module = strtoupper($request->query('module', 'BISINDO'));

        // Ambil huruf yang sudah dikuasai
        $mastered = UserProgress::where('user_id', Auth::id())
            ->where('module', $module)
            ->pluck('huruf')
            ->toArray();

        // Ambil semua data modul untuk module yang dipilih
        $moduls = Modul::where('modul', $module)
            ->orderBy('huruf', 'asc')
            ->get();

        // Buat data letter dengan thumbnail dan penjelasan
        $letterData = [];
        foreach ($moduls as $modul) {
            $letterData[$modul->huruf] = [
                'thumbnail' => $modul->thumbnail,
                'penjelasan' => $modul->penjelasan,
            ];
        }

        return response()->json([
            'mastered' => $mastered,
            'letterData' => $letterData,
        ]);
    }

    /**
     * POST /pembelajaran/progress/simpan
     * Simpan huruf yang sudah dikuasai user ke database
     */
    public function simpanProgress(Request $request)
    {
        $request->validate([
            'module' => 'required|in:BISINDO,SIBI',
            'huruf'  => 'required|string|size:1|regex:/^[A-Za-z]$/',
        ]);

        $module = strtoupper($request->module);
        $huruf  = strtoupper($request->huruf);

        // updateOrCreate agar tidak duplikat
        UserProgress::updateOrCreate([
            'user_id' => Auth::id(),
            'module'  => $module,
            'huruf'   => $huruf,
        ]);

        // Ambil semua huruf yang sudah dikuasai untuk modul ini
        $mastered = UserProgress::where('user_id', Auth::id())
            ->where('module', $module)
            ->pluck('huruf')
            ->toArray();

        // Ambil semua data modul untuk module yang dipilih
        $moduls = Modul::where('modul', $module)
            ->orderBy('huruf', 'asc')
            ->get();

        // Buat data letter dengan thumbnail dan penjelasan
        $letterData = [];
        foreach ($moduls as $modul) {
            $letterData[$modul->huruf] = [
                'thumbnail' => $modul->thumbnail,
                'penjelasan' => $modul->penjelasan,
            ];
        }

        return response()->json([
            'success'  => true,
            'mastered' => $mastered,
            'letterData' => $letterData,
            'message' => 'Progress berhasil disimpan',
        ]);
    }
}
