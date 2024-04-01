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
		'user_id',		
		'group_id',
	];
	
	public $timestamps = true;
	


	public function user(){
        return $this->belongsTo(User::class);
    }

	public function nextQuestion() {
			return $this->belongsToMany(Question::class, 'game_question','game_id','question_id')
			->withPivot('order','status','start_time','end_time')
			->orderByPivot('order', 'asc');
	}


	public function questions(){
	 	return $this->belongsToMany(Question::class, 'game_question','game_id','question_id')->withPivot('brand_id','order','status','start_time','end_time');  
    }
 
	public function brand(){
        return $this->belongsTo(Brand::class); 
    }

	public function type(){
        return $this->belongsTo(Type::class); 
    }
	
	public function group(){
        return $this->belongsTo(Group::class); 
    }
 
	public function teams(){
        return $this->hasMany(GameTeam::class); 
    }
	
}
