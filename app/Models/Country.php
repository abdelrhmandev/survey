<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use LaravelLocalization;
class Country extends Model
{
    protected $fillable = [
		'name',
		'code',
	];
	
	public $timestamps = false;
	
	
}
