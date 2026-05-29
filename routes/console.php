<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('reservas:cancelar-expiradas', function () {
    $this->call('reservas:cancelar-expiradas');
})->purpose('Cancela reservas pendientes de pago tras 24h');

Schedule::command('reservas:cancelar-expiradas')->hourly();