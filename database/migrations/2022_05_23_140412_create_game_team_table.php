<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateGameTeamTable extends Migration
{
    public function up(){
        Schema::create('game_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->string('team_title');
            $table->integer('capacity');

        });
    }
    public function down(){
        Schema::dropIfExists('game_team');
    }
}
