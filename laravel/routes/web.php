<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\PembelajaranController;
use App\Http\Controllers\HistoriController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\LatihanController;
use App\Http\Controllers\Admin\AdminKuisController;
use App\Http\Controllers\PraktikController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('landing');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/pembelajaran.index', [PembelajaranController::class, 'index'])->name('pembelajaran.index')->middleware('auth');

Route::get('/pembelajaran/sibi', function () {
    return view('pembelajaran.sibi');
})->name('pembelajaran.sibi')->middleware('auth');

Route::get('/pembelajaran/bisindo', function () {
    return view('pembelajaran.bisindo');
})->name('pembelajaran.bisindo')->middleware('auth');

Route::get('/pembelajaran/progress',         [PembelajaranController::class, 'getProgress'])->middleware('auth');
Route::post('/pembelajaran/progress/simpan', [PembelajaranController::class, 'simpanProgress'])->middleware('auth');

Route::get('/pembelajaran/{modul}/{huruf}', [PembelajaranController::class, 'showHuruf'])->name('pembelajaran.huruf')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
    Route::get('/histori', [HistoriController::class, 'index'])->name('histori');
    Route::get('/profil',  [ProfilController::class, 'index'])->name('profil');
    Route::put('/profil',  [ProfilController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfilController::class, 'updateAvatar'])->name('profile.avatar');

    // Praktik AI
    Route::post('/praktik/simpan', [PraktikController::class, 'simpan'])->name('praktik.simpan')->middleware('auth');
    Route::get('/praktik/riwayat/{modul}/{huruf}', [PraktikController::class, 'riwayatHuruf'])->name('praktik.riwayat')->middleware('auth');
});

Route::get('/latihan', [LatihanController::class, 'index'])->name('latihan')->middleware('auth');
Route::get('/latihan/soal', [LatihanController::class, 'getSoal'])->name('latihan.soal')->middleware('auth');
Route::post('/latihan/simpan-hasil', [LatihanController::class, 'simpanHasil'])->name('latihan.simpan')->middleware('auth');

Route::get('/praktik/{modul}/{huruf}', [PraktikController::class, 'show'])->name('praktik.huruf')->middleware('auth');


// ─── ADMIN ───────────────────────────────────────────────────────────────────

Route::get('/admin/login',  [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout',[AdminAuthController::class, 'logout'])->name('admin.logout');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [DashboardController::class, 'data'])->name('dashboard.data');
});
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/pengguna',  [AdminController::class, 'pengguna'])->name('pengguna');
    Route::get('/modul',     [AdminController::class, 'modul'])->name('modul');
    Route::post('/modul',    [AdminController::class, 'storeModul'])->name('modul.store');
    Route::put('/modul/{id}',[AdminController::class, 'updateModul'])->name('modul.update');

    // Kuis admin
    Route::get('/kuis',         [AdminKuisController::class, 'index'])->name('kuis');
    Route::get('/kuis/data',    [AdminKuisController::class, 'getData'])->name('kuis.data');
    Route::post('/soal',        [AdminKuisController::class, 'tambahSoal'])->name('soal.store');
    Route::put('/soal/{id}',    [AdminKuisController::class, 'editSoal'])->name('soal.update');
    Route::delete('/soal/{id}', [AdminKuisController::class, 'hapusSoal'])->name('soal.delete');
});
