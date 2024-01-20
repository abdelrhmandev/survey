<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Game extends Model
{

	protected $table = 'games';

    protected $fillable = [
		'title',
		'slug',
		'image',
		'description',
		'attendees',
		'play_with_team',
		'team_players',
		'event_id',
		'type_id',
	];
	
	public $timestamps = true;
	


	public function event(){
        return $this->belongsTo(Event::class); 
    }
	public function type(){
        return $this->belongsTo(Type::class); 
    }
 
	
}
