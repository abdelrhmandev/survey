<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
class GroupQuestion extends Model
{

	protected $table = 'group_question';

    protected $fillable = [
		'group_id',
		'question_id', 
		'order',
	];
	
	public $timestamps = false;
	
 
   
	public function question(){
        return $this->belongsTo(Question::class);
    }
 

	public function questions(){
        return $this->belongsToMany(Question::class,'questions','question_id','group_id');
    }
 
	
}
