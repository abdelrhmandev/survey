<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateTypesTable extends Migration
{
    public function up(){
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('image',150)->nullable();
            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('types');
    }
}
