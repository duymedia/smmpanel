<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('coupon_id')->constrained('coupons')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Item that consumed the coupon ÃƒÂ¢Ã¢â€šÂ¬Ã¢â‚¬Â matches usage.blade.php filter (service/product + id)
            $table->enum('item_type', ['service', 'product'])->nullable();
            $table->unsignedBigInteger('item_id')->nullable();

            $table->decimal('discount_value', 15, 4)->default(0);

            $table->string('domain')->nullable();
            $table->timestamps();

            $table->index(['coupon_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index(['item_type', 'item_id']);
            $table->index('domain');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupon_usages');
    }
};
