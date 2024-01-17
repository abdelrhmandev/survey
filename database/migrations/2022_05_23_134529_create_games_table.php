<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateGamesTable extends Migration
{
    public function up(){
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('attendees');
            $table->enum('play_with_team', ['0','1'])->default(1);
            $table->integer('team_players')->nullable();
            $table->foreignId('type_id')->constrained('types')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('games');
    }
}
