<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','status'
    ];
    protected $user_status = [
        1 => 'admin',
        2 => 'coach'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function isAdmin(){
//        session(['role' => 'admin']);
        return $this->status == 1;
        
    }
    
    public function isClient(){
//        session(['role' => 'client']);
//        $l_clients=\App\assign::where('user_id',$this->id)->where('role_id',\App\role::client())->pluck("package_id")->get();
        $client=\App\assign::where('user_id',$this->id)->where('role_id',\App\role::client())->count();
        return $client > 0;
    
    }
    
    public function isCoach(){
//        session(['role' => 'coach']);
//        $l_clients=\App\assign::where('user_id',$this->id)->where('role_id',\App\role::client())->pluck("package_id")->get();
         return $this->status == 2;
    
    }
    /**
     * Get the associated discussions
     *
     * @var array
     */
    public function discussions(){
     
        return $this->hasMany('App\discussion');
    
    }
    
    /**
     * Get the associated assignments
     *
     * @var array
     */
    public function assignments(){
     
        return $this->hasMany('App\assignment');
    
    }
    
     /**
     * Get the associated modules
     *
     * @var array
     */
    public function modules(){
     
        return $this->hasMany('App\modules');
    
    }
    
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }
    public function getCreatedAtAttribute($value)
    {
        return date("D F j, Y, g:i a",  strtotime($value));
    }
}
