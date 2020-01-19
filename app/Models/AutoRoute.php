<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AutoRoute extends Model
{
    protected $table = 'auto_route';
    public $fillable = [
      'id', 'name', 'controller_name'
    ];


    /**
     * 获取自动生成的路由
     *
     * @return mixed
     */
    public static function getAutoRoute()
    {
        try {
            $cacheRouteName = 'AutoRoute';
            if (Cache::has($cacheRouteName)) {
                $autoRoutes = Cache::get($cacheRouteName);
            } else {
                $autoRoutes = self::all();
                Cache::forever($cacheRouteName, $autoRoutes);
            }
        } catch (\Exception $e) {
        }

        return $autoRoutes ?? '';
    }

}
