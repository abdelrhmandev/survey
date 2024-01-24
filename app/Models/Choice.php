<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Choice extends Model
{

	protected $table = 'choices';

    protected $fillable = [
		'title',
		'question_id',
	];
	
	 
	public $timestamps = false;
 
 
	
}
