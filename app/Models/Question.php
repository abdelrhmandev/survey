<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Question extends Model
{

	protected $table = 'questions';

    protected $fillable = [
		'title',
		'game_id',
		'score',
		'time',
		// 'difficulty',
	];
	
	public $timestamps = true;
	

	public function game(){
        return $this->belongsTo(Game::class); 
    }


	public function answers(){
        return $this->hasMany(Answer::class); 
    }
 
	public function correctAnswer(){
        return $this->hasOne(QuestionCorrectAnswer::class); 
    }
	
}
