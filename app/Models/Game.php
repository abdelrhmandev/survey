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
		'color',
		'attendees',
		'play_with_team',
		'team_players',
		'event_title',
		'event_start_date',
		'event_end_date',
		'event_location',		
		'type_id',
		'pin',
		'status',		
		'brand_id',
	];
	
	public $timestamps = true;
	

	public function questions(){
	 	return $this->belongsToMany(Question::class, 'game_question','game_id','question_id')->withPivot('brand_id','order');  
    }
 
	public function brand(){
        return $this->belongsTo(Brand::class); 
    }

	public function type(){
        return $this->belongsTo(Type::class); 
    }
 
	public function teams(){
        return $this->hasMany(GameTeam::class); 
    }
	
}
