<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\SendWeeklyBookReport;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote()); 
})->purpose('Display an inspiring quote');

Schedule::command(SendWeeklyBookReport::class)->weeklyOn(1, '08:00');
