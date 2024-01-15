<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateUserTeamTable extends Migration
{
    public function up(){
        Schema::create('user_team', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('team_id')->constrained('posts')->onDelete('cascade');
            $table->unique(['user_id','team_id']);                  
        });
    }
    public function down(){
        Schema::dropIfExists('user_team');
    }
}
