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

	];
	
	public $timestamps = false;
	
    public function question(){
        return $this->belongsTo(Game::class, 'question_id');
    }
	public function ReorderQuestion(){
        return $this->belongsTo(Question::class, 'id');
    }
	
}
