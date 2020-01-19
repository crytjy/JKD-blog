<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    /**
     * 配置验证器实例.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->rules()) {
                if(count($validator->errors()->all())){
                    $validator->errors()->add('warning', $validator->errors()->all());
                }
            }
        });
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $pageType = $_SERVER['REQUEST_URI'];
        $rules = [];
        if($pageType == '/jkd/user/destroy') {
            $rules['id'] = 'required|integer';
        }

        return $rules;
    }


    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
          'id' => '缺少参数ID',
        ];
    }
}
