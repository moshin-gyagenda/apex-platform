<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('security_logs', function (Blueprint $table) {
            $table->id();
            $table->string('event_type');
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->string('ip_address', 45);
            $table->text('user_agent')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('email')->nullable();
            $table->string('route')->nullable();
            $table->string('method', 10)->nullable();
            $table->text('description')->nullable();
            $table->json('request_data')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->boolean('blocked')->default(false);
            $table->timestamp('blocked_at')->nullable();
            $table->timestamps();

            $table->index('ip_address');
            $table->index('event_type');
            $table->index('severity');
            $table->index('blocked');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_logs');
    }
};
