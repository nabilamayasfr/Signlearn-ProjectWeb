<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('praktik_results', function (Blueprint $table) {
            $table->id();

            // Siapa yang praktik
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Bahasa yang dipraktikkan: 'bisindo' atau 'sibi'
            $table->enum('language', ['bisindo', 'sibi']);

            // Huruf yang dipraktikkan: 'A' sampai 'Z'
            $table->string('huruf', 1);

            // Skor dari AI (0.00 - 1.00), kita simpan desimal
            // Contoh: confidence 0.92 = 92%
            $table->decimal('skor_ai', 5, 2);

            // Status hasil berdasarkan threshold skor
            // 'berhasil' jika skor >= 80%, 'perlu_latihan' jika < 80%
            $table->enum('status', ['berhasil', 'perlu_latihan']);

            // Huruf yang diprediksi AI (bisa berbeda dari target)
            // Contoh: target C tapi AI prediksi G
            $table->string('prediksi_ai', 1)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('praktik_results');
    }
};