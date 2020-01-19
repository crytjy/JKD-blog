<?php

namespace App\Repositories\Admin;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatRepository
{

    protected $modelChat;

    public function __construct(Chat $modelChat)
    {
        $this->modelChat = $modelChat;
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
        $data = $this->modelChat
          ->where(function ($query) use ($request) {
              $content = $request->get('content');
              if (isset($content)) {
                  $query->where('content', 'like', '%' . $content . '%')->get();
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
        return $this->modelChat->find($id);
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
        $res = $this->modelChat->create(array_only($data, $this->modelChat->fillable));
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
    public function update($request)
    {
        if ($request->get('id')) {
            $data = $request->all();
            $res = $this->modelChat->find($data['id']);
            $res->fill(array_only($data, $this->modelChat->fillable));
            $res->save();
            return [
                'msg' => '更新成功',
                'code' => 400,
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
        if($id){
            $res = $this->modelChat->where('id', $id)->delete();

            if($res){
                return [
                    'msg'=>'删除成功',
                    'code'=>200,
                    'type' => 'info'
                ];
            }
        }

        return [
            'msg'=>'没有权限',
            'code'=>400,
            'type' => 'warning'
        ];
    }

}