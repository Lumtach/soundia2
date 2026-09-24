<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('soundia:db-check', function () {
    $tables = [
        'settings',
        'pages',
        'pages_langs',
        'services',
        'service_langs',
        'service_audios',
        'portfolio',
        'portfolio_langs',
        'portfolio_images',
        'portfolio_audios',
    ];

    $this->line('Connection: ' . config('database.default'));
    $this->line('Database: ' . (config('database.connections.mysql.database') ?: '-'));

    try {
        $current = DB::selectOne('select database() as db');
        $this->line('Current DB: ' . ($current->db ?? '-'));
    } catch (Throwable $exception) {
        $this->error('DB connection failed: ' . $exception->getMessage());
        return self::FAILURE;
    }

    foreach ($tables as $table) {
        try {
            if (! Schema::hasTable($table)) {
                $this->warn($table . ': missing');
                continue;
            }

            $this->info($table . ': ' . DB::table($table)->count() . ' rows');
        } catch (Throwable $exception) {
            $this->error($table . ': ' . $exception->getMessage());
        }
    }

    try {
        $content = App\Support\SoundiaContent::load();
        $this->line('Loaded pages: ' . count($content['pages'] ?? []));
        $this->line('Loaded labels: ' . array_sum(array_map('count', $content['labels'] ?? [])));
        $this->line('Loaded services: ' . count($content['services'] ?? []));
        $this->line('Loaded portfolio: ' . count($content['projects'] ?? []));
        $this->line('Contact email: ' . ($content['contacts']['email'] ?? '-'));
    } catch (Throwable $exception) {
        $this->error('SoundiaContent failed: ' . $exception->getMessage());
        return self::FAILURE;
    }

    return self::SUCCESS;
})->purpose('Check Soundia database content loading');

