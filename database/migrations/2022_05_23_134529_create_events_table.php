<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateEventsTable extends Migration
{
    public function up(){
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('image',150)->nullable();
            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('events');
    }
}
