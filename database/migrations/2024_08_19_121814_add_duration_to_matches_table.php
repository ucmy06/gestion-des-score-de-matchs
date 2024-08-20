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
            $table->integer('duration')->nullable()->after('score_team_2');
        });
    }
    
    public function down()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->dropColumn('duration');
        });
    }
    
};
