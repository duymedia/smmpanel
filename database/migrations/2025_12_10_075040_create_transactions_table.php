<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('order_id')->nullable(); // link to orders table
            $table->decimal('amount', 20, 9);                  // supports tiny values like 1.0E-7
            $table->string('type', 32)->default('order');          // order | refund | deposit | bonus | adjustment
            $table->string('status', 32)->default('completed');    // completed | pending | failed
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('description')->nullable();
            $table->decimal('balance_after', 20, 9)->nullable();
            // GiÃƒÂ¡Ã‚Â»Ã¢â‚¬Âºi hÃƒÂ¡Ã‚ÂºÃ‚Â¡n Ãƒâ€žÃ¢â‚¬ËœÃƒÂ¡Ã‚Â»Ã†â€™ index (user_id, domain) khÃƒÆ’Ã‚Â´ng vÃƒâ€ Ã‚Â°ÃƒÂ¡Ã‚Â»Ã‚Â£t 1000 bytes trÃƒÆ’Ã‚Âªn MySQL cÃƒâ€¦Ã‚Â©.
            $table->string('domain')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('order_id');
            $table->index('type');
            $table->index('status');
            $table->index('created_at');
            $table->index(['user_id', 'created_at']);
            $table->index(['user_id', 'domain']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
