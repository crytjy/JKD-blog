<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\CategoryRepository;
use App\Http\Requests\Admin\CategoryPost;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    protected $repositoryCategory;
    public function __construct(CategoryRepository $repositoryCategory)
    {
        $this->repositoryCategory = $repositoryCategory;
    }


    /**
     * 首页
     *
     * @return mixed
     */
    public function index()
    {
        $title = '分类';

        return view('admin.category.index', compact('title'));
    }


    /**
     * 搜索
     *
     * @param Request $request
     * @return mixed
     */
    public function pageQuery(Request $request)
    {
        return $this->repositoryCategory->pageQuery($request);
    }


    /**
     * 编辑页
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $title = '分类';
        $id = $request->get('id') ?? 0;
        $detail = '';
        if($id){
            $detail = $this->getDetail($id);
        }

        return view('admin.category.add', compact('title', 'detail'));
    }


    /**
     * 详情
     *
     * @param $id
     * @return mixed
     */
    public function getDetail($id)
    {
        return $this->repositoryCategory->getDetail($id);
    }


    /**
     * 新增
     *
     * @param CategoryPost $request
     * @return array
     */
    public function store(CategoryPost $request)
    {
        $cacheCategoryName = 'Category';
        Cache::forget($cacheCategoryName);
        return $this->repositoryCategory->store($request);
    }


    /**
     * 更新
     *
     * @param CategoryPost $request
     * @return mixed
     */
    public function update(CategoryPost $request)
    {
        $cacheCategoryName = 'Category';
        Cache::forget($cacheCategoryName);
        return $this->repositoryCategory->update($request);
    }


    /**
     * 删除
     *
     * @param CategoryPost $request
     * @return array
     */
    public function destroy(CategoryPost $request)
    {
        $cacheCategoryName = 'Category';
        Cache::forget($cacheCategoryName);
        return $this->repositoryCategory->destroy((int)$request->id);
    }


    /**
     * 批量保存
     *
     * @param CategoryPost $request
     * @return array
     */
    public function batchUpdate(CategoryPost $request)
    {
        return $this->repositoryCategory->batchUpdate($request->params);
    }


    /**
     * 获取分类
     *
     * @return mixed
     */
    public function getCategory()
    {
        return $this->repositoryCategory->getCategory();
    }

}
