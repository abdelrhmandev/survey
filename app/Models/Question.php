<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Question extends Model
{

	protected $table = 'questions';

    protected $fillable = [
		'title',
		'brand_id',
		'score',
		'time',
		// 'difficulty',
	];
	
	public $timestamps = true;
	

	public function brand(){
        return $this->belongsTo(Brand::class); 
    }


	public function answers(){
        return $this->hasMany(Answer::class); 
    }
 
	public function correctAnswer(){
        return $this->hasOne(QuestionCorrectAnswer::class); 
    }
	
}
