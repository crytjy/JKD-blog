<?php
namespace App\Repositories\Admin;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoryRepository
{
    protected $modelCategory;

    public function __construct(Category $modelCategory)
    {
        $this->modelCategory = $modelCategory;
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
            $sort = 'sort';
            $order = 'desc';
        }

        //搜索条件
        $data = $this->modelCategory
          ->where(function ($query) use ($request) {
              $title = $request->get('title');
              if (isset($title)) {
                  $query->where('title', 'like', '%' . $title . '%')->get();
              }

              $status = $request->get('status');
              if (isset($status)) {
                  $query->where('status', $status);
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
        return $this->modelCategory->find($id);
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
        $data['keywords'] = $data['keywords'] ? implode(',', $data['keywords']) : '';
        $res = $this->modelCategory->create(array_only($data, $this->modelCategory->fillable));
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
            $data['keywords'] = $data['keywords'] ? implode(',', $data['keywords']) : '';
            $res = $this->modelCategory->find($data['id']);
            $res->fill(array_only($data, $this->modelCategory->fillable));
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
            $articleCategory = $this->modelCategory->whereHas('category')->find($id);
            if ($articleCategory) {
                $res = $this->modelCategory->where('id', $id)->delete();

                if ($res) {
                    return [
                        'msg' => '删除成功',
                        'code' => 200,
                        'type' => 'success'
                    ];
                }
            } else {
                return [
                    'msg' => '该标签已被使用，请先去除文章的该分类！',
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
                $this->modelCategory->where('id', $pms[0])
                  ->update(['sort' => $pms[1]]);
            }
        }

        return [
            'msg' => '编辑成功记录数' . $i,
            'type' => 'warning'
        ];
    }


    /**
     * 获取分类
     *
     * @return mixed
     */
    public function getCategory()
    {
        return $this->modelCategory->where('status', 1)->get(['id', 'title']);
    }


}