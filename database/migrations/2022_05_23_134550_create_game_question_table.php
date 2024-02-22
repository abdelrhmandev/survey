<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateGameQuestionTable extends Migration
{
    public function up(){
        Schema::create('game_question', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->tinyInteger('order')->nullable();
        });
    }
    public function down(){
        Schema::dropIfExists('game_question');
    }
}
