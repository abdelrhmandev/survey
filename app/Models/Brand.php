<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Brand extends Model
{

	protected $table = 'brands';


    protected $fillable = [
		'title',
		'slug',
	];
	
	public $timestamps = true;
	
	public function questions(){
        return $this->hasMany(Question::class); 
    }

	
}
