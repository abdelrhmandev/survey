<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class QuestionCorrectAnswer extends Model
{

	protected $table = 'question_correct_answer';

    protected $fillable = [
		'question_id',
		'correct_answer_id',
	];
	
	public $timestamps = false;
	


	public function choices(){
        return $this->hasMany(Choice::class); 
    }
 
	
}
