<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Player extends Model 
{

	protected $table = 'players';

    protected $fillable = [
		'name',
		'game_id',
		'game_team_id',
	];
	public $timestamps = true;	
 
	public function game(){
        return $this->belongsTo(Game::class); 
    }
	 
}
