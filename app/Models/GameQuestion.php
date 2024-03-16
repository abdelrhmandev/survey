<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
class GameQuestion extends Model
{

	protected $table = 'game_question';

    protected $fillable = [
		'brand_id',
		'game_id', 
		'question_id',
		'order',
		'status',
		'start_time',
		'end_time',
	];
	
	public $timestamps = false;
	
 
   

	public function question(){
        return $this->belongsTo(Question::class, 'question_id');
    }
 
	
}
