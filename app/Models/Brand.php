<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Brand extends Model
{

	protected $table = 'brands';


    protected $fillable = [
		'title',
	];
	
	public $timestamps = true;
	
	public function groups(){
        return $this->hasMany(Group::class); 
    }
	public function questions(){
        return $this->hasMany(Question::class); 
    }
}
