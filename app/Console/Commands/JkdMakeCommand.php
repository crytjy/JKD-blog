<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use  App\Models\AutoRoute;
use Illuminate\Support\Facades\Cache;

class JkdMakeCommand extends Command
{
    /**
     * 1. 这里是命令行调用的名字, 如这里的: `jkd`,
     * 命令行调用的时候就是 `php artisan jkd`
     *  --l 存放路径
     *  --m 模型名称
     * @var string
     */
    protected $signature = 'jkd {--l=} {--m=}';

    /**
     * 2. 这里填写命令行的描述, 当执行 `php artisan` 时
     *   可以看得见.
     *
     * @var string
     */
    protected $description = '自动生成默认模版';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 3. 执行代码,
     *
     * @return mixed
     */
    public function handle()
    {
        $location = $this->option('l');
        $modelName = $this->option('m');
        $ucfirstName = ucfirst($modelName);
        $strtolowerName = strtolower($modelName);
        $ucfirstLocationName = ucfirst($location);

        $controllerPath = $ucfirstLocationName . '/' . $ucfirstName . 'Controller';
        $repositoryPath = $ucfirstLocationName . '/' . $ucfirstName . 'Repository';
        $requestPath = $ucfirstLocationName . '/' . $ucfirstName . config('jkd.requestSuffix');
        $modelPath = $ucfirstName;
        $jsPath = $location . '/' . $modelName;
        $addPath = $location . '/' . $strtolowerName;
        $indexPath = $location . '/' . $strtolowerName;

        Artisan::call('make:jkd-table ' . $strtolowerName);             //创建数据表
        Artisan::call('make:jkd-model ' . $modelPath);                  //创建模型
        Artisan::call('make:jkd-controller ' . $controllerPath);        //创建控制器
        Artisan::call('make:jkd-repository ' . $repositoryPath);        //创建资源库
        Artisan::call('make:jkd-add ' . $addPath);                      //创建视图add
        Artisan::call('make:jkd-index ' . $indexPath);                  //创建视图index
        Artisan::call('make:jkd-js ' . $jsPath);                        //创建js
        Artisan::call('make:jkd-request ' . $requestPath);              //创建验证器

        try {
            Artisan::call('migrate');
        } catch (\Exception $e) {
            $this->error('Data table already exists');
            return '';
        }

        //新增路由
        $routeData = [
          'name' => $strtolowerName,
          'controller_name' => $ucfirstName . 'Controller'
        ];
        try {
            AutoRoute::create($routeData);
            Cache::forget('AutoRoute');
        } catch (\Exception $e) { }

        $this->info('Create a new temp Success');
        return '';
    }

}