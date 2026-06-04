<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PraktikResult extends Model
{
    protected $fillable = [
        'user_id',
        'language',
        'huruf',
        'skor_ai',
        'status',
        'prediksi_ai',
        'duration_seconds',
    ];

    protected $casts = [
        'skor_ai' => 'float',
        'duration_seconds' => 'integer',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Helper: skor dalam persen (0.92 → 92)
    public function getSkorPersenAttribute(): int
    {
        return (int) round($this->skor_ai * 100);
    }

    // ── Helper: label status yang ramah untuk tampilan
    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'berhasil' ? 'Berhasil' : 'Perlu Latihan';
    }

    // ── Helper: emoji status
    public function getStatusEmojiAttribute(): string
    {
        return $this->status === 'berhasil' ? '✅' : '⚠️';
    }
}