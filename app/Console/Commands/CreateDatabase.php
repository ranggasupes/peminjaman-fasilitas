<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateDatabase extends Command
{
    protected $signature = 'db:create';
    protected $description = 'Membuat database peminjaman fasilitas';

    public function handle()
    {
        $database = config('database.connections.mysql.database');

        DB::statement(
            "CREATE DATABASE IF NOT EXISTS `{$database}`"
        );

        $this->info("Database {$database} berhasil dibuat.");

        return self::SUCCESS;
    }
}
