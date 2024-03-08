<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreatePlayerSubmittedAnswerTable extends Migration
{
    public function up(){
        Schema::create('player_submitted_answer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id');
            $table->foreignId('question_id');            
            $table->foreignId('game_team_id')->nullable(); // if game have multi teamscls
            $table->foreignId('answer_id')->nullable(); // submitted answer id
            $table->integer('score');
            $table->integer('time');
            $table->enum('status', ['pending','opened','closed'])->default('pending');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('player_submitted_answer');
    }
}
