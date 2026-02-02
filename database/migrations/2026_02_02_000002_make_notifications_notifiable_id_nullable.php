<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Drop the existing index first
            $table->dropIndex(['notifiable_type', 'notifiable_id']);
        });

        // Make notifiable_id nullable
        DB::statement('ALTER TABLE notifications MODIFY notifiable_id BIGINT UNSIGNED NULL');

        // Re-add the index
        Schema::table('notifications', function (Blueprint $table) {
            $table->index(['notifiable_type', 'notifiable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['notifiable_type', 'notifiable_id']);
        });

        DB::statement('ALTER TABLE notifications MODIFY notifiable_id BIGINT UNSIGNED NOT NULL');

        Schema::table('notifications', function (Blueprint $table) {
            $table->index(['notifiable_type', 'notifiable_id']);
        });
    }
};
