<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('meilisearch:reindex')
    ->dailyAt('2:00')
    ->description('Reindexează automat Meilisearch în fiecare noapte la ora 2:00');
