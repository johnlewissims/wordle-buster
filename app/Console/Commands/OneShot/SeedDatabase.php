<?php

namespace App\Console\Commands\OneShot;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SeedDatabase extends Command
{
    protected $signature = 'one-shot:db:seed-sql';
    protected $description = 'Seed database with SQL file';

    public function handle()
    {
        $path = base_path('words.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
        $this->info('Database seeded successfully from SQL file.');
    }
}
