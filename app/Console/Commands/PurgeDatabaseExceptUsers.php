<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PurgeDatabaseExceptUsers extends Command
{
    protected $signature = 'db:purge-except-users {--force : Run without confirmation prompt}';

    protected $description = 'Truncate every table except `users` (MySQL / SQLite).';

    public function handle(): int
    {
        if (! $this->option('force') && ! $this->confirm('This will delete all data except the users table. Continue?')) {
            $this->warn('Aborted.');

            return self::FAILURE;
        }

        $driver = Schema::getConnection()->getDriverName();
        if (! in_array($driver, ['mysql', 'sqlite'], true)) {
            $this->error('Unsupported database driver: '.$driver.'. Use MySQL or SQLite.');

            return self::FAILURE;
        }

        $tables = $this->listBaseTables($driver);

        if ($tables === []) {
            $this->error('No tables found.');

            return self::FAILURE;
        }

        $keep = ['users'];
        $toTruncate = array_values(array_filter($tables, function (string $name) use ($keep) {
            return ! in_array($name, $keep, true);
        }));

        if ($toTruncate === []) {
            $this->info('Nothing to truncate.');

            return self::SUCCESS;
        }

        Schema::disableForeignKeyConstraints();
        try {
            foreach ($toTruncate as $table) {
                DB::table($table)->truncate();
            }
        } finally {
            Schema::enableForeignKeyConstraints();
        }

        $this->info('Truncated '.count($toTruncate).' table(s). Preserved: '.implode(', ', $keep).'.');

        return self::SUCCESS;
    }

    /**
     * @return list<string>
     */
    private function listBaseTables(string $driver): array
    {
        if ($driver === 'mysql') {
            $db = DB::getDatabaseName();
            $key = 'Tables_in_'.$db;
            $rows = DB::select('SHOW FULL TABLES WHERE Table_type = ?', ['BASE TABLE']);
            $names = [];
            foreach ($rows as $row) {
                if (isset($row->{$key}) && is_string($row->{$key})) {
                    $names[] = $row->{$key};
                }
            }

            return $names;
        }

        if ($driver === 'sqlite') {
            $rows = DB::select("SELECT name FROM sqlite_master WHERE type = 'table' AND name NOT LIKE 'sqlite_%'");
            $names = [];
            foreach ($rows as $row) {
                if (isset($row->name) && is_string($row->name)) {
                    $names[] = $row->name;
                }
            }

            return $names;
        }

        return [];
    }
}
