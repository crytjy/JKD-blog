<?php
namespace App\Repositories\Admin;


use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LinkRepository
{

    protected $modelLink;

    public function __construct(Link $modelLink)
    {
        $this->modelLink = $modelLink;
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
            $sort = 'sort';
            $order = 'desc';
        }

        //搜索条件
        $data = $this->modelLink
          ->where(function ($query) use ($request) {
              $title = $request->get('title');
              if (isset($title)) {
                  $query->where('title', 'like', '%' . $title . '%')->get();
              }
          })
          ->orderby($sort, $order)
          ->orderby('id', 'desc')
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
        return $this->modelLink->find($id);
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
        $res = $this->modelLink->create(array_only($data, $this->modelLink->fillable));
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
            $res = $this->modelLink->find($data['id']);
            $res->fill(array_only($data, $this->modelLink->fillable));
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
        if($id){
            $res = $this->modelLink->where('id', $id)->delete();

            if($res){
                return [
                    'msg' => '删除成功',
                    'code' => 200,
                    'type' => 'success'
                ];
            }
        }

        return [
            'msg'=>'没有权限',
            'code'=>400,
            'type' => 'warning'
        ];
    }


    /**
     * 批量更新
     *
     * @param $params
     * @return array
     */
    public function batchUpdate($params)
    {
        $rows = explode(",", $params);

        for ($i = 0; $i < count($rows); $i++) {
            $pms = explode(":", $rows[$i]);

            if (is_numeric($pms[0]) && is_numeric($pms[1])) {
                $this->modelLink->where('id', $pms[0])
                  ->update(['sort' => $pms[1]]);
            }
        }

        return [
            'msg' => '编辑成功记录数：' . $i,
            'code' => 200,
            'type' => 'warning'
        ];
    }

}