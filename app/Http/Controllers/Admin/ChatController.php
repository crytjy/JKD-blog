<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChatPost;
use Illuminate\Http\Request;
use App\Repositories\Admin\ChatRepository;


class ChatController extends Controller
{

    protected $repositoryChat;
    public function __construct(ChatRepository $repositoryChat)
    {
        $this->repositoryChat = $repositoryChat;
    }


    /**
     * 首页
     *
     * @return mixed
     */
    public function index()
    {
        $title = '随言碎语';

        return view('admin.chat.index', compact('title'));
    }


    /**
     * 搜索
     *
     * @param Request $request
     * @return mixed
     */
    public function pageQuery(Request $request)
    {
        return $this->repositoryChat->pageQuery($request);
    }


    /**
     * 编辑页
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $title = '随言碎语';
        $id = $request->get('id') ?? 0;
        $detail = '';
        if($id){
            $detail = $this->getDetail($id);
        }

        return view('admin.chat.add', compact('title', 'detail'));
    }


    /**
     * 详情
     *
     * @param $id
     * @return mixed
     */
    public function getDetail($id)
    {
        return $this->repositoryChat->getDetail($id);
    }


    /**
     * 新增
     *
     * @param ChatPost $request
     * @return array
     */
    public function store(ChatPost $request)
    {
        return $this->repositoryChat->store($request);
    }


    /**
     * 更新
     *
     * @param ChatPost $request
     * @return mixed
     */
    public function update(ChatPost $request)
    {
        return $this->repositoryChat->update($request);
    }


    /**
     * 删除
     *
     * @param ChatPost $request
     * @return array
     */
    public function destroy(ChatPost $request)
    {
        return $this->repositoryChat->destroy((int)$request->id);
    }

}
