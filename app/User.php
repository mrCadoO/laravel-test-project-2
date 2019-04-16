<?php

namespace Corp;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'login',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function articles(){
        return $this->hasMany('Corp\Article');
    }

    public function roles(){
        return $this->belongsToMany('Corp\Role', 'role_user');
    }



    public function canDo($permission, $require = false){
        if(is_array($permission)){
            foreach($permission as $perName){
                $perName = $this->canDo($perName);
                if($perName && !$require){
                    return true;
                } elseif(!$perName && $require){
                    return false;
                }
            }
            return $require;
        } else {
            foreach($this->roles as $role) {

               foreach($role->permissions as $perm){
                    if(str_is($permission,$perm->name)){
                        return true;
                    }
               }
            }
        }
    }


    public function hasRole($name, $require = false){
        if(is_array($name)){
            foreach($name as $roleName){
                $hasRole = $this->hasRole($roleName);

                if(!$hasRole && !$require){
                    return true;
                } elseif(!$hasRole && $require){
                    return false;
                }
            }
            return $require;
        } else {
            foreach($this->roles as $role){
                if($role->name == $name){
                    return true;
                }
            }
        }
        return false;
    }



}
