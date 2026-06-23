<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Modul;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function pengguna()
    {
        $users = User::latest()->get();

        return view('admin_akun', compact('users'));
    }

    public function modul()
    {
        $moduls = Modul::orderBy('modul')->orderBy('huruf')->get();

        $bisindo = $moduls->where('modul', 'BISINDO');
        $sibi = $moduls->where('modul', 'SIBI');

        return view('admin-modul', compact('moduls', 'bisindo', 'sibi'));
    }

    public function storeModul(Request $request)
    {
        $request->validate([
            'modul' => 'required|in:SIBI,BISINDO',
            'huruf' => [
                'required',
                'string',
                'size:1',
                Rule::unique('moduls')->where(function ($query) use ($request) {
                    return $query->where('modul', strtoupper($request->modul))
                                 ->where('huruf', strtoupper($request->huruf));
                }),
            ],
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'penjelasan' => 'nullable|string',
        ]);

        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Tentukan folder berdasarkan modul
            $folder = strtolower($request->modul) === 'bisindo' ? 'bisindo' : 'sibi';

            // Simpan langsung ke folder public/assets/pembelajaran
            $destinationPath = public_path("assets/pembelajaran/{$folder}");

            // Buat folder jika belum ada
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Pindahkan file ke public
            $file->move($destinationPath, $filename);

            // Simpan path relatif dari folder public
            $thumbnailPath = "assets/pembelajaran/{$folder}/{$filename}";
        }

        Modul::create([
            'modul' => strtoupper($request->modul),
            'huruf' => strtoupper($request->huruf),
            'thumbnail' => $thumbnailPath,
            'penjelasan' => $request->penjelasan,
        ]);

        return redirect()->route('admin.modul')->with('success', 'Modul berhasil ditambahkan.');
    }

    public function updateModul(Request $request, $id)
    {
        $modulData = Modul::findOrFail($id);

        $request->validate([
            'modul' => 'required|in:SIBI,BISINDO',
            'huruf' => [
                'required',
                'string',
                'size:1',
                Rule::unique('moduls')->where(function ($query) use ($request) {
                    return $query->where('modul', strtoupper($request->modul))
                                 ->where('huruf', strtoupper($request->huruf));
                })->ignore($modulData->id),
            ],
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'penjelasan' => 'nullable|string',
        ]);

        $thumbnailPath = $modulData->thumbnail;

        if ($request->hasFile('thumbnail')) {
            // Hapus file lama dari public
            if ($modulData->thumbnail && File::exists(public_path($modulData->thumbnail))) {
                File::delete(public_path($modulData->thumbnail));
            }

            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Tentukan folder berdasarkan modul (gunakan modul dari request)
            $folder = strtolower($request->modul) === 'bisindo' ? 'bisindo' : 'sibi';

            // Simpan langsung ke folder public
            $destinationPath = public_path("assets/pembelajaran/{$folder}");

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $thumbnailPath = "assets/pembelajaran/{$folder}/{$filename}";
        }

        $modulData->update([
            'modul' => strtoupper($request->modul),
            'huruf' => strtoupper($request->huruf),
            'thumbnail' => $thumbnailPath,
            'penjelasan' => $request->penjelasan,
        ]);

        return redirect()->route('admin.modul')->with('success', 'Modul berhasil diperbarui.');
    }

    public function kuis()
    {
        return view('admin_kuis');
    }
}
