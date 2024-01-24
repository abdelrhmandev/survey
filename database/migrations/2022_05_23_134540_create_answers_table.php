<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateAnswersTable extends Migration
{
    public function up(){
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->string('title');           
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
        });
    }
    public function down(){
        Schema::dropIfExists('answers');
    }
}
