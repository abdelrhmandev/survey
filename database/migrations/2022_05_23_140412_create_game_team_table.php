<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateGameTeamTable extends Migration
{
    public function up(){
        Schema::create('game_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id');
            $table->string('team_title');
            $table->integer('capacity');
        });
    }
    public function down(){
        Schema::dropIfExists('game_team');
    }
}
