<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ArticlePost extends FormRequest
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
        if ($pageType != '/jkd/article/store') {
            $rules['id'] = 'required|integer';
        }
        if ($pageType != '/jkd/article/destroy') {
            $rules['category_id'] = 'required|integer';
            $rules['title'] = 'required|string';
            $rules['content'] = 'required|string';
            $rules['keywords'] = 'array';
            $rules['description'] = 'required|string';
            $rules['is_top'] = 'required|integer';
            $rules['is_original'] = 'required|integer';
            $rules['status'] = 'required|integer';
            $rules['tag_id'] = 'array';
            $rules['pic'] = 'string';
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
          'category_id.required' => '请选择分类',
          'category_id.integer' => '分类格式有误',
          'title.required' => '请填写名称',
          'title.string' => '名称格式有误',
          'content.required' => '请填写内容',
          'keywords' => '关键词格式有误',
          'description.required' => '请填写简述',
          'description.string' => '简述格式有误',
          'is_top.required' => '请选择是否置顶',
          'is_top.string' => '是否置顶格式有误',
          'is_original.required' => '请选择是否原创',
          'is_original.string' => '是否原创格式有误',
          'status.required' => '请选择状态',
          'status.string' => '状态格式有误',
          'tag_id' => '标签格式有误',
          'pic' => '封面图片有误'
        ];
    }
}
