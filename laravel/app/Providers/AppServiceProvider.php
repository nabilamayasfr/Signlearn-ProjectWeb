<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Timezone untuk format tampilan tanggal
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}