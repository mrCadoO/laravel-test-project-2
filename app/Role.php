<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    public function users(){
        return $this->belongsToMany('Corp\User', 'role_user');
    }

    public function permissions(){
        return $this->belongsToMany('Corp\Permission', 'permission_role');
    }

    public function hasPermission($name, $require = false){
        if(is_array($name)){
            foreach($name as $permissionName){
                $hasPermission = $this->hasPermission($permissionName);

                if($hasPermission && !$require){
                    return true;
                } elseif(!$hasPermission && $require){
                    return false;
                }
            }
            return $require;
        } else {
            foreach($this->permissions as $permission){
                if($permission->name == $name){
                    return true;
                }
            }
        }
        return false;
    }


    public function savePermissions($input_permission){

        if(!empty($input_permission)){
            $this->permissions()->sync($input_permission);
        } else {
            $this->permissions()->detach();
        }
        return true;
    }

}
