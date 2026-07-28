<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Services\ReservaService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Aquí programas la revisión automática
Schedule::call(function (ReservaService $reservaService) {
    $reservaService->procesarCancelacionesAutomaticas();
})->everyMinute();