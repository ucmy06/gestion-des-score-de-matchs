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
        // Assurer que tous les utilisateurs qui sont supposés être administrateurs ont le rôle 'admin'
        DB::table('users')
            ->where('role', 'employee') // Modifier si nécessaire pour cibler les utilisateurs spécifiques
            ->update(['role' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Réinitialiser les rôles pour tous les utilisateurs
        DB::table('users')
            ->where('role', 'admin')
            ->update(['role' => 'employee']);
    }
};