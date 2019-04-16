<?php

namespace Corp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Auth;
use \Route;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return Auth::user()->canDo('ADD_ARTICLES');
    }



    protected function getValidatorInstance(){
        $validator = parent::getValidatorInstance();

        $validator->sometimes('alias', 'unique:articles|max:255', function($input){
        $current_param = Route::current();

            if(isset($current_param->parameters) && $current_param->article){
                $model = $this->route()->parameters('articles');
                return ($model['article'] !== $input->alias) && !empty($input->alias);
            }
            return !empty($input->alias);
        });
        return $validator;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'text' => 'required',
            'category_id' => 'required|integer'
        ];
    }
}
