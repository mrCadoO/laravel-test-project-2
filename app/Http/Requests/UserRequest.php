<?php

namespace Corp\Http\Requests;

use Corp\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return \Auth::user()->canDo('EDIT_USERS');
    }



    protected function getValidatorInstance(){
        $validator = parent::getValidatorInstance();

        $validator->sometimes('password', 'required|confirmed|min:6', function($input){

            if(!empty($input->password) || (empty($input->password) && $this->route()->getName() !== 'admin.users.update')){
                return true;
            }

            return false;
        });
        return $validator;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        $current_id = $this->route()->parameters;
        $id = isset($this->route()->parameters['user']) ? $this->route()->parameters['user'] : '';

        return [
            'name' => 'required|max:255',
            'login' => 'required|max:255',
            'role_id' => 'required|integer',
            'email' => 'required|email|max:255|unique:users,email,'.$id
        ];
    }
}
