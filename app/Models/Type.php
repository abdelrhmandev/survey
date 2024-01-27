<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Type extends Model
{

	protected $table = 'types';


    protected $fillable = [
		'title',
		'slug',
		'image',
		'description'
	];
	
	public $timestamps = true;
	


	public function games(){
        return $this->hasMany(Game::class); 
    }

	
}
