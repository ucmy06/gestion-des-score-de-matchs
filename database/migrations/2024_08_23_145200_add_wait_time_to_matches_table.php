<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->integer('wait_time')->nullable()->after('duration'); // Temps d'attente avant le lancement du match en secondes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->dropColumn('wait_time');
        });
    }
};
