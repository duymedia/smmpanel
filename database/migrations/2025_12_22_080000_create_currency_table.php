<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currency', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->string('symbol');
            $table->decimal('exchange_rate', 15, 8)->default(1.00000000);
            $table->string('name');
            $table->boolean('sync')->default(false);
            $table->tinyInteger('status')->default(1);
            $table->enum('symbol_position', ['before', 'after'])->default('before');
            $table->string('domain')->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('status');
            $table->index('domain');
            $table->index('code');
            $table->index(['status', 'domain']);
            $table->index('created_at');
        });

        $metadata = getCurrencyData();
        $symbols = $metadata['symbols'] ?? [];
        $names = $metadata['names'] ?? [];
        $rates = [];

        try {
            $api = fetchCurrencyRates('USD');
            if ($api && !empty($api['conversion_rates'])) {
                $rates = $api['conversion_rates'];
            }
        } catch (\Throwable $e) {
            Log::warning('Không lấy được tỷ giá từ API, dùng tỷ giá mặc định: ' . $e->getMessage());
        }

        $codes = $rates ? array_keys($rates) : array_keys($symbols);
        $symbolAfter = ['CHF', 'CZK', 'NOK', 'PLN', 'RUB', 'SEK', 'VND'];
        $domain = getDomain();
        $now = now();
        $rows = [];

        foreach ($codes as $code) {
            $rows[] = [
                'code' => $code,
                'symbol' => $symbols[$code] ?? $code,
                'exchange_rate' => $code === 'USD' ? 1 : roundExchangeRate($rates[$code] ?? 1),
                'name' => $names[$code] ?? $code,
                'sync' => $code !== 'USD',
                'status' => 1,
                'symbol_position' => in_array($code, $symbolAfter, true) ? 'after' : 'before',
                'domain' => $domain,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if ($rows) {
            DB::table('currency')->insert($rows);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency');
    }
};
