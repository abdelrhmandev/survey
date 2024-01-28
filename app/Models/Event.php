<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Event extends Model
{

	protected $table = 'events';


    protected $fillable = [
		'title',
		'slug',
		'description',
		'start_date',
		'end_date',
		'image',		
	];
	
	public $timestamps = true;
	
	public function games(){
        return $this->belongsTo(Game::class,'id','event_id'); 
    }

	
}
