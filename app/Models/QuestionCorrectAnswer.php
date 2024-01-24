<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class QuestionCorrectAnswer extends Model
{

	protected $table = 'questions';

    protected $fillable = [
		'title',
		'game_id',
		'score',
		'time',
		'difficulty',
	];
	
	public $timestamps = true;
	


	public function choices(){
        return $this->hasMany(Choice::class); 
    }
 
	
}
