<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateGroupQuestionTable extends Migration
{
    public function up(){
        Schema::create('group_question', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id');
            $table->foreignId('question_id');
            $table->tinyInteger('order')->nullable();
        });
    }
    public function down(){
        Schema::dropIfExists('group_question');
    }
}
