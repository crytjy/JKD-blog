<?php

namespace App\Repositories\Admin;

use App\Http\Controllers\Admin\UploadController;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleRepository
{

    protected $modelArticle;

    public function __construct(Article $modelArticle)
    {
        $this->modelArticle = $modelArticle;
    }


    /**
     * 搜索
     *
     * @param Request $request
     * @return mixed
     */
    public function pageQuery(Request $request)
    {
        if (!empty($request['sort'])) {
            $order = $request['order'];
            $sort = $request['sort'];

            switch ($sort) {
                case 'status':
                    $sort = 'status';
                    break;
            }
        } else {
            $sort = 'id';
            $order = 'desc';
        }

        //搜索条件
        $data = $this->modelArticle
            ->with('category')
            ->with('tag')
            ->where(function ($query) use ($request) {
                $title = $request->get('title');
                if (isset($title)) {
                    $query->where('title', 'like', '%' . $title . '%')->get();
                }
            })
            ->orderby($sort, $order)
            ->paginate($request['rows']);

        $returnData = json_decode(json_encode($data), true);
        $returnData['footer'] = $returnData['total'];

        return $returnData;
    }


    /**
     * 详情
     *
     * @param $id
     * @return mixed
     */
    public function getDetail($id)
    {
        return $this->modelArticle->with('tag')->find($id);
    }


    /**
     * 新增
     *
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $tagData = $data['tag_id'] ?? [];
        if ($request->hasFile('attachment')) {
            $controllerUpload = new UploadController();
            $data['pic'] = $controllerUpload->uploadFile($request);
            $picUrl = Storage::disk('public')->url($data['pic']);
            $isAddWater = env('IS_ADD_WATER');
            if($isAddWater) {
                addWater('./storage/' . $data['pic']);
            }
            //上传七牛云
            if(!Storage::disk('qiniu')->exists($data['pic'])) {
                Storage::disk('qiniu')->put($data['pic'], file_get_contents($picUrl));
            }
        }
        $user = Auth::user();
        $userId = $user ? $user->id : 0;
        $userName = $user ? $user->name : '';
        $data['user_id'] = $userId;
        $data['last_update_id'] = $userId;
        $data['author'] = $userName;
        $data['keywords'] = implode(',', $data['keywords']);
        $res = $this->modelArticle->create(array_only($data, $this->modelArticle->fillable));
        $res->tag()->sync($tagData);

        if ($res) {
            $baiduSiteUrl = env('BAIDU_SITE_URL');
            if ($baiduSiteUrl) {
                baiduSite($res->id);
            }

            return [
                'msg' => '保存成功',
                'code' => 200,
                'id' => $res->id,
                'pic' => $picUrl ?? '',
                'type' => 'success'
            ];
        }

        return [
            'msg' => '保存失败',
            'code' => 400,
            'type' => 'warning'
        ];
    }


    /**
     * 更新
     *
     * @param $request
     * @return array
     */
    public function update(Request $request)
    {
        if ($request->get('id')) {
            $data = $request->all();
            $tagData = $data['tag_id'] ?? [];

            $controllerUpload = new UploadController();
            if ($request->hasFile('attachment')) {
                $data['pic'] = $controllerUpload->uploadFile($request);
                $isAddWater = env('IS_ADD_WATER');
                if($isAddWater) {
                    addWater('./storage/' . $data['pic']);
                }
            }

            $user = Auth::user();
            $userId = $user ? $user->id : 0;
            $data['last_update_id'] = $userId;
            $data['keywords'] = implode(',', $data['keywords']);
            $res = $this->modelArticle->find($data['id']);
            $resPic = $res->pic ? explode('storage', $res->pic)[1] : '';
            if (isset($data['pic']) && $resPic) {
                $controllerUpload->delFile($resPic);
            }
            $data['pic'] = $data['pic'] ?? $resPic;

            $pic = $data['pic'] ? Storage::disk('public')->url($data['pic']) : '';
            //上传七牛云
            if(!Storage::disk('qiniu')->exists($data['pic'])) {
                Storage::disk('qiniu')->put($data['pic'], file_get_contents($pic));
            }

            $res->fill(array_only($data, $this->modelArticle->fillable));
            $res->save();
            $res->tag()->sync($tagData);

            $baiduSiteUrl = env('BAIDU_SITE_URL');
            if ($baiduSiteUrl) {
                baiduSite($data['id']);
            }
            return [
                'msg' => '更新成功',
                'code' => 200,
                'id' => $data['id'],
                'pic' => $pic,
                'type' => 'success'
            ];
        }

        return [
            'msg' => '参数有误',
            'code' => 400,
            'type' => 'warning'
        ];
    }


    /**
     * 删除
     *
     * @param int $id
     * @return array
     */
    public function destroy(int $id)
    {
        if ($id) {
            $res = $this->modelArticle->where('id', $id)->delete();

            if ($res) {
                return [
                    'msg' => '删除成功',
                    'code' => 200,
                    'type' => 'success'
                ];
            }
        }

        return [
            'msg' => '没有权限',
            'code' => 400,
            'type' => 'warning'
        ];
    }

}
