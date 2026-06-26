<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\QuizResult;
use App\Models\PraktikResult;

class ProfilController extends Controller
{
    /**
     * Tampilkan halaman profil + statistik user.
     */
    public function index()
    {
        $user   = Auth::user();
        $userId = $user->id;

        // ── Total latihan (kuis + praktik) ──
        $totalKuis    = QuizResult::where('user_id', $userId)->count();
        $totalPraktik = PraktikResult::where('user_id', $userId)->count();
        $totalLatihan = $totalKuis + $totalPraktik;

        // ── Praktik terakhir (dari AI detection) ──
        $praktikTerakhir = PraktikResult::where('user_id', $userId)
                                        ->latest()
                                        ->first();

        // Data huruf terakhir sekarang dari tabel praktik_results
        $hurufTerakhir    = $praktikTerakhir?->huruf ?? '-';
        $bahasaTerakhir   = $praktikTerakhir ? strtoupper($praktikTerakhir->language) : '-';
        $skorTerakhir     = $praktikTerakhir ? (int) round($praktikTerakhir->skor_ai * 100) : null;
        $tanggalTerakhir  = $praktikTerakhir
                            ? $praktikTerakhir->created_at->locale('id')->isoFormat('D MMMM YYYY')
                            : null;

        // ── Progress: huruf yang pernah BERHASIL dipraktikkan ──
        $hurufDikuasaiPraktik = PraktikResult::where('user_id', $userId)
            ->where('status', 'berhasil')
            ->distinct('huruf')
            ->pluck('huruf')
            ->map(fn($h) => strtoupper($h))
            ->unique();

        // Tambah dari kuis yang pernah benar
        $semuaHasilKuis = QuizResult::where('user_id', $userId)->get();
        $hurufBenarKuis = collect();
        foreach ($semuaHasilKuis as $hasil) {
            if (!$hasil->answers_detail) continue;
            foreach ($hasil->answers_detail as $ans) {
                if ($ans['is_correct'] === true) {
                    $hurufBenarKuis->push(strtoupper($ans['correct_answer']));
                }
            }
        }

        $hurufDikuasaiPraktik52 = PraktikResult::where('user_id', $userId)
            ->where('status', 'berhasil')
            ->select('language', 'huruf')
            ->distinct()
            ->get()
            ->map(fn($r) => $r->language . '-' . $r->huruf);

        $progressCount   = $hurufDikuasaiPraktik52->unique()->count();
        $progressPercent = round(($progressCount / 52) * 100);

        // ── Statistik per bahasa ──
        $statPerBahasa = [
            'bisindo' => [
                'total_kuis'        => QuizResult::where('user_id', $userId)->where('language', 'bisindo')->count(),
                'total_praktik'     => PraktikResult::where('user_id', $userId)->where('language', 'bisindo')->count(),
                'rata_skor_kuis'    => round(QuizResult::where('user_id', $userId)->where('language', 'bisindo')->avg('score_percentage') ?? 0),
                'rata_skor_praktik' => round((PraktikResult::where('user_id', $userId)->where('language', 'bisindo')->avg('skor_ai') ?? 0) * 100),
                'skor_terbaik'      => round((PraktikResult::where('user_id', $userId)->where('language', 'bisindo')->max('skor_ai') ?? 0) * 100),
            ],
            'sibi' => [
                'total_kuis'        => QuizResult::where('user_id', $userId)->where('language', 'sibi')->count(),
                'total_praktik'     => PraktikResult::where('user_id', $userId)->where('language', 'sibi')->count(),
                'rata_skor_kuis'    => round(QuizResult::where('user_id', $userId)->where('language', 'sibi')->avg('score_percentage') ?? 0),
                'rata_skor_praktik' => round((PraktikResult::where('user_id', $userId)->where('language', 'sibi')->avg('skor_ai') ?? 0) * 100),
                'skor_terbaik'      => round((PraktikResult::where('user_id', $userId)->where('language', 'sibi')->max('skor_ai') ?? 0) * 100),
            ],
        ];

        return view('profil', compact(
            'user',
            'totalLatihan',
            'hurufTerakhir',
            'bahasaTerakhir',
            'skorTerakhir',
            'tanggalTerakhir',
            'progressCount',
            'progressPercent',
            'statPerBahasa',
        ));
    }

    /**
     * Update avatar / foto profil (simpan di assets/avatars)
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $user = Auth::user();

        // Hapus avatar lama jika ada
        if ($user->avatar && file_exists(public_path('assets/avatars/' . $user->avatar))) {
            unlink(public_path('assets/avatars/' . $user->avatar));
        }

        // Upload avatar baru ke assets/avatars
        $file = $request->file('avatar');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('assets/avatars'), $filename);

        // Simpan nama file ke database
        $user->avatar = $filename;
        $user->save();

        return redirect()->route('profil')->with('success', 'Foto profil berhasil diupdate!');
    }

    /**
     * Simpan perubahan profil user.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap'    => 'required|string|max:100',
            'username'        => ['nullable', 'string', 'max:50', Rule::unique('users', 'username')->ignore($user->id)],
            'email'           => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'nomor_telepon'   => 'nullable|string|max:20',
            'tanggal_lahir'   => 'nullable|date|before:today',
            'jenis_kelamin'   => 'nullable|in:Laki-laki,Perempuan',
            'password'        => 'nullable|string|min:8|confirmed',
        ]);

        // Update field dasar
        $user->name  = $request->nama_lengkap;
        $user->email = $request->email;

        // Update username jika kolom ada
        if (isset($user->username)) {
            $user->username = $request->username;
        }

        // Update phone jika kolom ada
        if (isset($user->phone)) {
            $user->phone = $request->nomor_telepon;
        }

        // Update birth_date jika kolom ada
        if (isset($user->birth_date)) {
            $user->birth_date = $request->tanggal_lahir;
        }

        // Update gender jika kolom ada
        if (isset($user->gender)) {
            $user->gender = $request->jenis_kelamin;
        }

        // Update password hanya kalau diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui!');
    }
}
