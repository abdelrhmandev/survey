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
        return $this->belongsTo(Question::class,'id','brand_id'); 
    }

	
}
