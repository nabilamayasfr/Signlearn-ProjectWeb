<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    protected $table = 'user_progresses'; // tambahkan ini
    protected $fillable = ['user_id', 'module', 'huruf'];
}
