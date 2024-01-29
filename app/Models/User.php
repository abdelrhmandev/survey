<?php
namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\AdminPasswordResetNotification as ResetPasswordNotification;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles;
    

    protected $table = 'users';


     protected $guard_name = 'admin';
 
    protected $fillable = [
        'name',
        'username',
        'email',
        'mobile',
        'password',
        'avatar',
        'status',
        'country_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function teams(){
        return $this->belongsToMany(Team::class, 'user_team','user_id','team_id'); 
    }

    // public function getRoleNames(){
    //     return $this->roles->pluck('display');
    // }
    // public function setPasswordAttribute($value) // to make password encrypted automatic
    // {
    //     $this->attributes['password'] = Hash::make($value);
    // }

    
        public function sendPasswordResetNotification($token){
            $this->notify(new ResetPasswordNotification($token));
        }
}
