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
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->integer('score');
            $table->integer('time');

            $table->enum('status', ['pending','opened','closed'])->default('pending');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('questions');
    }
}
