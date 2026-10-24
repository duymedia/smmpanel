<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            $table->string('code', 50);
            $table->enum('discount_type', ['percent', 'fixed'])->default('percent');
            $table->decimal('discount_value', 15, 4)->default(0);

            // Limits ÃƒÂ¢Ã¢â€šÂ¬Ã¢â‚¬Â null = unlimited
            $table->unsignedInteger('usage_limit')->nullable();
            $table->unsignedInteger('usage_per_account')->nullable();
            $table->unsignedInteger('used_count')->default(0);

            // Validity window
            $table->dateTime('start_date');
            $table->dateTime('end_date');

            // Restrictions
            $table->json('account_role')->nullable();          // ["user","reseller","vip"]
            $table->enum('item_type', ['service', 'product'])->nullable(); // null = all orders
            $table->decimal('min_order', 15, 4)->nullable();

            $table->text('note')->nullable();
            $table->boolean('status')->default(true);

            $table->string('domain')->nullable();
            $table->timestamps();

            $table->unique(['domain', 'code']);
            $table->index(['status', 'start_date', 'end_date']);
            $table->index('domain');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
