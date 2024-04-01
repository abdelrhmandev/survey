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
            $table->string('slug');
            $table->string('image',150)->nullable();
            $table->text('description')->nullable();
            $table->string('color',20)->nullable();
            $table->foreignId('type_id');
            $table->foreignId('brand_id');
            $table->foreignId('group_id');
            $table->foreignId('user_id');
            $table->integer('attendees');
            $table->enum('play_with_team', ['0','1'])->default(1);
            $table->enum('status', ['pending','opened','closed'])->default('pending');
            $table->integer('team_players')->nullable();
            $table->string('event_title');
            $table->date('event_start_date');
            $table->date('event_end_date');
            $table->string('event_location');
            $table->string('pin',10)->unique();            
            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('games');
    }
}
