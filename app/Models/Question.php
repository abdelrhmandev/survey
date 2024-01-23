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
		'difficulty',
	];
	
	public $timestamps = true;
	


	public function event(){
        return $this->belongsTo(Event::class); 
    }
	public function type(){
        return $this->belongsTo(Type::class); 
    }
 
	
}
