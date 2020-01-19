<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LinkPost;
use App\Repositories\Admin\LinkRepository;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    protected $repositoryLink;
    public function __construct(LinkRepository $repositoryLink)
    {
        $this->repositoryLink = $repositoryLink;
    }


    /**
     * 首页
     *
     * @return mixed
     */
    public function index()
    {
        $title = '友链';

        return view('admin.link.index', compact('title'));
    }


    /**
     * 搜索
     *
     * @param Request $request
     * @return mixed
     */
    public function pageQuery(Request $request)
    {
        return $this->repositoryLink->pageQuery($request);
    }


    /**
     * 编辑页
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $title = '友链';
        $id = $request->get('id') ?? 0;
        $detail = '';
        if($id){
            $detail = $this->getDetail($id);
        }

        return view('admin.link.add', compact('title', 'detail'));
    }


    /**
     * 详情
     *
     * @param $id
     * @return mixed
     */
    public function getDetail($id)
    {
        return $this->repositoryLink->getDetail($id);
    }


    /**
     * 新增
     *
     * @param LinkPost $request
     * @return array
     */
    public function store(LinkPost $request)
    {
        return $this->repositoryLink->store($request);
    }


    /**
     * 更新
     *
     * @param LinkPost $request
     * @return mixed
     */
    public function update(LinkPost $request)
    {
        return $this->repositoryLink->update($request);
    }


    /**
     * 删除
     *
     * @param LinkPost $request
     * @return array
     */
    public function destroy(LinkPost $request)
    {
        return $this->repositoryLink->destroy((int)$request->id);
    }
    

    /**
     * 批量保存
     *
     * @param LinkPost $request
     * @return array
     */
    public function batchUpdate(LinkPost $request)
    {
        return $this->repositoryLink->batchUpdate($request->params);
    }

}
