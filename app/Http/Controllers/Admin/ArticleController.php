<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticlePost;
use App\Repositories\Admin\ArticleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{

    protected $repositoryArticle;
    public function __construct(ArticleRepository $repositoryArticle)
    {
        $this->repositoryArticle = $repositoryArticle;
    }


    /**
     * 首页
     *
     * @param CategoryController $controllerCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(CategoryController $controllerCategory)
    {
        $title = '文章';

        $cacheCategoryName = 'Category';
        if(Cache::has($cacheCategoryName)){
            $categoryData = Cache::get($cacheCategoryName);
        }else{
            $categoryData = $controllerCategory->getCategory();
            Cache::forever($cacheCategoryName, $categoryData);
        }

        return view('admin.article.index', compact('title', 'categoryData'));
    }


    /**
     * 搜索
     *
     * @param Request $request
     * @return mixed
     */
    public function pageQuery(Request $request)
    {
        return $this->repositoryArticle->pageQuery($request);
    }


    /**
     * 编辑页
     *
     * @param Request $request
     * @param CategoryController $controllerCategory
     * @param TagController $controllerTag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, CategoryController $controllerCategory, TagController $controllerTag)
    {
        $title = '文章';
        $id = $request->get('id') ?? 0;
        $detail = '';
        if($id){
            $detail = $this->getDetail($id);
            $tagValueData = $detail->tag ? $detail->tag->toArray() : '';
            $tagValueData = $tagValueData ? array_column($tagValueData, 'id') : [];
        }
        $tagValueData = $tagValueData ? collect($tagValueData) : '';

        //分类
        $cacheCategoryName = 'Category';
        if(Cache::has($cacheCategoryName)){
            $categoryData = Cache::get($cacheCategoryName);
        }else{
            $categoryData = $controllerCategory->getCategory();
            Cache::forever($cacheCategoryName, $categoryData);
        }

        //标签
        $cacheTagName = 'Tag';
        if(Cache::has($cacheTagName)){
            $tagData = Cache::get($cacheTagName);
        }else{
            $tagData = $controllerTag->getTag();
            Cache::forever($cacheTagName, $tagData);
        }

        return view('admin.article.add', compact('title', 'detail', 'categoryData', 'tagData', 'tagValueData'));
    }


    /**
     * 详情
     *
     * @param $id
     * @return mixed
     */
    public function getDetail($id)
    {
        return $this->repositoryArticle->getDetail($id);
    }


    /**
     * 新增
     *
     * @param ArticlePost $request
     * @return array
     */
    public function store(ArticlePost $request)
    {
        return $this->repositoryArticle->store($request);
    }


    /**
     * 更新
     *
     * @param ArticlePost $request
     * @return mixed
     */
    public function update(ArticlePost $request)
    {
        return $this->repositoryArticle->update($request);
    }


    /**
     * 删除
     *
     * @param ArticlePost $request
     * @return array
     */
    public function destroy(ArticlePost $request)
    {
        return $this->repositoryArticle->destroy((int)$request->id);
    }

}
