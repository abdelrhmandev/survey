<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateGameAttendensPlayerTable extends Migration
{

    

    public function up(){
        Schema::create('game_attendens_player', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
   
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
             $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('game_attendens_player');
    }
}
