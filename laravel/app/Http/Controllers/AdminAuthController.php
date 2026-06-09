<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // Tampilkan halaman login admin
    public function showLogin()
    {
        // Kalau sudah login sebagai admin, langsung ke dashboard
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.pengguna');
        }

        // Kalau login sebagai user biasa, logout dulu
        if (Auth::check() && Auth::user()->role !== 'admin') {
            Auth::logout();
        }

        return view('auth.admin');
    }

    // Proses login admin
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            // Cek role admin
            if (Auth::user()->role === 'admin') {
                $request->session()->regenerate();

                // ← INI yang penting: redirect ke admin dashboard, BUKAN beranda
                return redirect()->route('admin.pengguna');
            }

            // Login berhasil tapi bukan admin
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akun ini tidak memiliki akses admin.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}