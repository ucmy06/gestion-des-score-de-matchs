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
        Schema::table('logs', function (Blueprint $table) {
            $table->integer('points_changed')->nullable(); // Points ajoutés ou retirés
            $table->string('change_type')->nullable(); // 'increment' ou 'decrement'
            $table->timestamp('changed_at')->nullable(); // Heure de changement
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->dropColumn(['points_changed', 'change_type', 'changed_at']);
        });
    }
};
