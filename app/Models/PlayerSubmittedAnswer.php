<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PlayerSubmittedAnswer extends Model
{

	protected $table = 'player_submitted_answers';

    protected $fillable = [
		'game_id',
		'player_id',
		'question_id',
		'game_team_id',
		'answer_id',
		'score',
		'time',
		'status',
		'start_time',
		'end_time'
	];
	
	public $timestamps = true;
	

 
 
	
}
