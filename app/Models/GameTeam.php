<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class GameTeam extends Model
{

	protected $table = 'game_team';

    protected $fillable = [
		'game_id',
		'team_title',
		'type_id',
	];
	
	public $timestamps = false;
	
}
