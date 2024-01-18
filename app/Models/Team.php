<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Team extends Model
{
    protected $fillable = [
		'title',
		'slug',
		'description'
	];
	
	public $timestamps = true;
	


	public function user(){
        return $this->belongsToMany(User::class, 'user_team','team_id','user_id'); 
    }
	
}
