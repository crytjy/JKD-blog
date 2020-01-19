<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TagPost;
use App\Repositories\Admin\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TagController extends Controller
{
    protected $repositoryTag;
    public function __construct(TagRepository $repositoryTag)
    {
        $this->repositoryTag = $repositoryTag;
    }


    /**
     * 首页
     *
     * @return mixed
     */
    public function index()
    {
        $title = '标签';

        return view('admin.tag.index', compact('title'));
    }


    /**
     * 搜索
     *
     * @param Request $request
     * @return mixed
     */
    public function pageQuery(Request $request)
    {
        return $this->repositoryTag->pageQuery($request);
    }


    /**
     * 编辑页
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $title = '标签';
        $id = $request->get('id') ?? 0;
        $detail = '';
        if($id){
            $detail = $this->getDetail($id);
        }

        return view('admin.tag.add', compact('title', 'detail'));
    }


    /**
     * 详情
     *
     * @param $id
     * @return mixed
     */
    public function getDetail($id)
    {
        return $this->repositoryTag->getDetail($id);
    }


    /**
     * 新增
     *
     * @param TagPost $request
     * @return array
     */
    public function store(TagPost $request)
    {
        $cacheTagName = 'Tag';
        Cache::forget($cacheTagName);
        return $this->repositoryTag->store($request);
    }


    /**
     * 更新
     *
     * @param TagPost $request
     * @return mixed
     */
    public function update(TagPost $request)
    {
        $cacheTagName = 'Tag';
        Cache::forget($cacheTagName);
        return $this->repositoryTag->update($request);
    }


    /**
     * 删除
     *
     * @param TagPost $request
     * @return array
     */
    public function destroy(TagPost $request)
    {
        $cacheTagName = 'Tag';
        Cache::forget($cacheTagName);
        return $this->repositoryTag->destroy((int)$request->id);
    }


    /**
     * 获取标签
     *
     * @return mixed
     */
    public function getTag()
    {
        return $this->repositoryTag->getTag();
    }
}
