<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'cache' => static function (Blueprint $table): void {
                $table->string('key')->primary();
                $table->mediumText('value');
                $table->integer('expiration')->index();
            },
            'cache_locks' => static function (Blueprint $table): void {
                $table->string('key')->primary();
                $table->string('owner');
                $table->integer('expiration')->index();
            },
        ];

        foreach ($tables as $name => $columns) {
            if (!Schema::hasTable($name)) Schema::create($name, $columns);
        }

        $connection = DB::connection();
        if (!in_array($connection->getDriverName(), ['mysql', 'mariadb'], true)) return;

        $charset = (string) $connection->getConfig('charset');
        $collation = (string) $connection->getConfig('collation');
        if (!preg_match('/^[a-z0-9_]+$/i', $charset) || !preg_match('/^[a-z0-9_]+$/i', $collation)) {
            throw new RuntimeException('Invalid database charset or collation configuration.');
        }

        foreach (array_keys($tables) as $name) {
            DB::statement("ALTER TABLE `{$name}` CONVERT TO CHARACTER SET {$charset} COLLATE {$collation}");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
