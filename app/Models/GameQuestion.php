<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class GameQuestion extends Model
{

	protected $table = 'game_qustion';

    protected $fillable = [
		'brand_id',
		'game_id', 
		'question_id',
		'order',

	];
	
	public $timestamps = false;
	

	 
	
}
