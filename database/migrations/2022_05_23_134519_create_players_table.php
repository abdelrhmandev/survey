<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateplayersTable extends Migration
{
    public function up(){
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('game_id');
            $table->foreignId('game_team_id')->nullable(); // case of teams
            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('players');
    }
}
