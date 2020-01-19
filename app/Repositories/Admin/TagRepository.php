<?php

namespace App\Repositories\Admin;


use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagRepository
{

    protected $modelTag;

    public function __construct(Tag $modelTag)
    {
        $this->modelTag = $modelTag;
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
                case 'created_at':
                    $sort = 'created_at';
                    break;
            }
        } else {
            $sort = 'id';
            $order = 'desc';
        }

        //搜索条件
        $data = $this->modelTag
          ->where(function ($query) use ($request) {
              $title = $request->get('title');
              if (isset($title)) {
                  $query->where('title', 'like', '%' . $title . '%')->get();
              }

              $createdAt = $request->get('created_at');
              if (isset($createdAt)) {
                  $query->where(DB::raw('date(chat.created_at)'), $createdAt);
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
        return $this->modelTag->find($id);
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
        $res = $this->modelTag->create(array_only($data, $this->modelTag->fillable));
        if ($res) {
            return [
              'msg' => '保存成功',
              'code' => 200,
              'id' => $res->id,
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
            $res = $this->modelTag->find($data['id']);
            $res->fill(array_only($data, $this->modelTag->fillable));
            $res->save();
            return [
              'msg' => '更新成功',
              'code' => 200,
              'id' => $data['id'],
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
            $articleTag = $this->modelTag->whereHas('article')->find($id);
            if ($articleTag) {
                $res = $this->modelTag->where('id', $id)->delete();

                if ($res) {
                    return [
                      'msg' => '删除成功',
                      'code' => 200,
                      'type' => 'success'
                    ];
                }
            } else {
                return [
                  'msg' => '该标签已被使用，请先去除文章的该标签！',
                  'code' => 400,
                  'type' => 'warning'
                ];
            }
        }

        return [
          'msg' => '没有权限',
          'code' => 400,
          'type' => 'warning'
        ];
    }


    /**
     * 获取标签
     *
     * @return mixed
     */
    public function getTag()
    {
        return $this->modelTag->where('status', 1)->get(['id', 'title']);
    }

}