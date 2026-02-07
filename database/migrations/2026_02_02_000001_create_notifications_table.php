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
        if (Schema::hasTable('notifications')) {
            return;
        }

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // low_stock, new_order, new_sale, system_update, etc.
            $table->string('title');
            $table->text('message');
            $table->string('icon')->nullable(); // lucide icon name
            $table->string('color')->default('primary'); // primary, green, yellow, red, etc.
            $table->morphs('notifiable'); // polymorphic relation (can be user, system, etc.) - automatically creates index
            $table->json('data')->nullable(); // additional data (product_id, order_id, etc.)
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->index('read_at');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
