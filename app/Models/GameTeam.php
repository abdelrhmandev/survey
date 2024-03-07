<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class GameTeam extends Model
{

	protected $table = 'game_team';

    protected $fillable = [
		'game_id',
		'team_title',
		'capacity',
	];
	
	public $timestamps = false;

	public function game(){
       return $this->belongsTo(Game::class,'game_id','id');
    }
	
}
