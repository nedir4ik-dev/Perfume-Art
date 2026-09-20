<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\BackupController;

// 1. Her gün gije sagat 00:00-da täze nusga alýar
Schedule::command('backup:run --only-db')->daily();

// 2. Her gün gije sagat 01:00-da 1 hepdeden köne backup-lary arassalaýar
Schedule::call(function () {
    app(BackupController::class)->clean();
})->dailyAt('01:00');

// 3. Her aýyň 1-ine gije sagat 00:05-de köne loglary arassalaýar
// 'monthly()' adaty ýagdaýda aýyň 1-ine sagat 00:00-da işleýär. 
// Ony 00:05-e goýsak, backup bilen çaknyşmaz.
Schedule::command('logs:clean')->monthlyOn(1, '00:05');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
