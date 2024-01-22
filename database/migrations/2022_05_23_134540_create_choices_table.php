<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateChoicesTable extends Migration
{
    public function up(){
        Schema::create('choices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('is_correct_answer', ['0','1'])->default(0);
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('choices');
    }
}
