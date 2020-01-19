<?php
namespace App\Repositories\Admin;

use App\Models\User;
use Illuminate\Http\Request;


class UserRepository
{

    protected $modelUser;
    public function __construct(User $modelUser)
    {
        $this->modelUser = $modelUser;
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
                case 'name':
                    $sort = 'name';
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
        $data = $this->modelUser
          ->where(function ($query) use ($request) {
              $name = $request->get('name');
              if (isset($name)) {
                  $query->where('name', 'like', '%'.$name.'%')->get();
              }

              $email = $request->get('email');
              if (isset($email)) {
                  $query->where('email', 'like', '%'.$email.'%');
              }
          })
          ->orderby($sort, $order)
          ->paginate($request['rows']);

        $returnData = json_decode(json_encode($data), true);
        $returnData['footer'] = $returnData['total'];

        return $returnData;
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
            $res = $this->modelUser->where('id', $id)->delete();

            if($res){
                return [
                    'msg'=>'删除成功',
                    'code'=>200,
                    'type' => 'success'
                ];
            }
        }

        return [
            'msg'=>'参数错误',
            'code'=>400,
            'type' => 'warning'
        ];
    }

}