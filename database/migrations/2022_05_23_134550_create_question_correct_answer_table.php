<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateQuestionCorrectAnswerTable extends Migration
{
    public function up(){
        Schema::create('question_correct_answer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->foreignId('correct_choice_id')->constrained('choices')->onDelete('cascade');
        });
    }
    public function down(){
        Schema::dropIfExists('question_correct_answer');
    }
}
