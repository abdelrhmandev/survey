<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreatePlayerSubmittedAnswersTable extends Migration
{
    public function up(){
        Schema::create('player_submitted_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id');
            $table->foreignId('question_id');            
            $table->foreignId('game_id');
            $table->foreignId('game_team_id')->nullable(); // if game have multi teamscls
            $table->foreignId('answer_id'); // submitted answer id
            $table->integer('score')->nullable();
            $table->integer('time')->nullable();
            $table->enum('status', ['pending','opened','closed'])->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('player_submitted_answers');
    }
}
