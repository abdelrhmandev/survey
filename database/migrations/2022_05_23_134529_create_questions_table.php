<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateQuestionsTable extends Migration
{
    public function up(){
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->integer('score');
            $table->integer('time');
            // $table->string('difficulty');
            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('questions');
    }
}
