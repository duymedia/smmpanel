<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_custom_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            // service_id = -1 means all active services
            $table->integer('service_id')->default(0);
            // Fixed price override (null = not set)
            $table->decimal('rate', 15, 8)->nullable();
            // Percent multiplier e.g. 110 = 110% of original rate (null = not set)
            $table->decimal('percent', 8, 2)->nullable();
            $table->string('domain')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('user_id');
            $table->index('service_id');
            $table->index('domain');
            // One custom rate per user per service per domain
            $table->unique(['user_id', 'service_id', 'domain'], 'ucr_user_service_domain_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_custom_rates');
    }
};
