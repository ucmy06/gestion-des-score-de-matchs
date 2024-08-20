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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_1_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('team_2_id')->constrained('teams')->onDelete('cascade');
            $table->bigInteger('score_team_1')->unsigned();
            $table->bigInteger('score_team_2')->unsigned();
            $table->timestamp('match_date')->useCurrent(); // Utiliser l'heure actuelle par défaut
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
