<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_sync_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->string('provider_name')->nullable();
            $table->string('service_api')->nullable();
            $table->string('change_type')->default('price_increase');
            $table->decimal('old_value', 20, 4)->nullable();
            $table->decimal('new_value', 20, 4)->nullable();
            $table->string('field_changed')->nullable();
            $table->boolean('is_read')->default(false);
            $table->string('domain')->nullable();
            // log_type: 'api' = Ãƒâ€žÃ¢â‚¬ËœÃƒÂ¡Ã‚Â»Ã¢â‚¬Å“ng bÃƒÂ¡Ã‚Â»Ã¢â€žÂ¢ tÃƒÂ¡Ã‚Â»Ã‚Â« API (hiÃƒÂ¡Ã‚Â»Ã†â€™n thÃƒÂ¡Ã‚Â»Ã¢â‚¬Â¹ user), 'website' = thay Ãƒâ€žÃ¢â‚¬ËœÃƒÂ¡Ã‚Â»Ã¢â‚¬Â¢i nÃƒÂ¡Ã‚Â»Ã¢â€žÂ¢i bÃƒÂ¡Ã‚Â»Ã¢â€žÂ¢
            $table->enum('log_type', ['website', 'api'])->default('api');
            // sync_batch: UUID nhÃƒÆ’Ã‚Â³m tÃƒÂ¡Ã‚ÂºÃ‚Â¥t cÃƒÂ¡Ã‚ÂºÃ‚Â£ logs tÃƒÂ¡Ã‚Â»Ã‚Â« cÃƒÆ’Ã‚Â¹ng 1 lÃƒÂ¡Ã‚ÂºÃ‚Â§n chÃƒÂ¡Ã‚ÂºÃ‚Â¡y cron
            $table->string('sync_batch', 36)->nullable();
            $table->json('changes')->nullable();
            $table->timestamps();

            $table->index(['domain', 'is_read']);
            $table->index('service_id');
            $table->index('created_at');
            $table->index('log_type');
            $table->index('sync_batch');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_sync_logs');
    }
};
