<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kho sÃƒÂ¡Ã‚ÂºÃ‚Â£n phÃƒÂ¡Ã‚ÂºÃ‚Â©m (warehouse) - danh sÃƒÆ’Ã‚Â¡ch kho
        Schema::create('product_warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('domain');
            $table->integer('position')->default(0);
            $table->timestamps();

            $table->index('domain');
        });

        // HÃƒÆ’Ã‚Â ng tÃƒÂ¡Ã‚Â»Ã¢â‚¬Å“n kho - tÃƒÂ¡Ã‚Â»Ã‚Â«ng item trong kho
        Schema::create('product_goods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_id')->constrained('product_warehouses')->onDelete('cascade');
            $table->text('content'); // NÃƒÂ¡Ã‚Â»Ã¢â€žÂ¢i dung sÃƒÂ¡Ã‚ÂºÃ‚Â£n phÃƒÂ¡Ã‚ÂºÃ‚Â©m (key, account, link...)
            $table->boolean('used')->default(false);
            $table->timestamps();

            $table->index('warehouse_id');
            $table->index('used');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_goods');
        Schema::dropIfExists('product_warehouses');
    }
};
