<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Player extends Model implements JWTSubject
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

	public function getJWTIdentifier()
    {
        return $this->getKey();
    }
	public function getJWTCustomClaims()
    {
        return [
			
		];
    }
	 
}
