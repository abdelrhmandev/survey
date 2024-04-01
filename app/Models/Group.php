<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Group extends Model
{

	protected $table = 'groups';


    protected $fillable = [
		'title',
		'brand_id',
	];
	
	public $timestamps = true;
	
	public function brand(){
        return $this->belongsTo(Brand::class); 
    }
	public function questions(){
        return $this->belongsToMany(Question::class); 
    }
	
	
}
