<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LinkPost extends FormRequest
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
        if($pageType == '/jkd/link/batchUpdate') {
            $rules['params'] = 'required';
        }elseif($pageType) {
            if ($pageType != '/jkd/link/store') {
                $rules['id'] = 'required|integer';
            }
            if ($pageType != '/jkd/link/destroy') {
                $rules['title'] = 'required|string';
                $rules['url'] = 'required|string';
                $rules['status'] = 'required|integer';
            }
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
          'title.required' => '请填写名称',
          'title.string' => '格式有误',
          'url' => '请填写链接',
          'status' => '请选择状态'
        ];
    }
}
