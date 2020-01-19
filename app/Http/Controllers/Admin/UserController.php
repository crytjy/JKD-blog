<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\UserRepository;
use App\Http\Requests\Admin\UserPost;


class UserController extends Controller
{

    protected $repositoryUser;
    public function __construct(UserRepository $repositoryUser)
    {
        $this->repositoryUser = $repositoryUser;
    }


    /**
     * 首页
     * 
     * @return mixed
     */
    public function index()
    {
        $title = '用户列表';

        return view('admin.user.index', compact('title'));
    }


    /**
     * 搜索
     *
     * @param Request $request
     * @return mixed
     */
    public function pageQuery(Request $request)
    {
        return $this->repositoryUser->pageQuery($request);
    }


    /**
     * 删除
     *
     * @param UserPost $request
     * @return mixed
     */
    public function destroy(UserPost $request)
    {
        return $this->repositoryUser->destroy((int)$request->id);
    }

}
