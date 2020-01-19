#JKD Blog 后台模版

- laravel(v6.6.0) 
- adminLTE3 
- easyUI
- 七牛云
- 百度搜索平台
- 方糖推送

前期快速开发后台模板 http://localhost/jkd

###环境要求
- php >= 7.2

###默认模板的生成
    php artisan jkd --l=admin --m=cry
    // --l: 文件存放路径  --m: 模型名称
    
###配置config
- 可更具需求更改配置 (/config/jkd.php)


    //模型名称前缀
    'modelPrefix' => 'model',

    //资源库名称前缀
    'repositoryPrefix' => 'repository',

    //资源库路径固定前缀
    'repositoryPathPrefix' => 'App\\Repositories\\',

    //请求验证名称后缀
    'requestSuffix' => 'Post',

    //路由前缀
    'routePrefix' => '/jkd/',

    //默认封面图片
    'default_img' => '/images/jkdlogo.png'


###路由
- 通过命令生成的模板，其路由将存入数据库，不需更改。
- 手动创建的模板，其路由不需更新到数据库，将其写入 /routes/jkd.php，
    
    
    ***其他配置，勿删除***
    
    //路由例子
    Route::get('demo', 'DemoController@index')->name('demo');                             //列表首页
    Route::get('demo/pageQuery', 'DemoController@pageQuery')->name('demo.pageQuery');     //搜索
    Route::post('demo/destroy', 'DemoController@destroy')->name('demo.destroy');          //删除
    Route::post('demo/store', 'DemoController@store')->name('demo.store');                //新增
    Route::post('demo/update', 'DemoController@update')->name('demo.update');             //更新
    Route::get('demo/edit', 'DemoController@edit')->name('demo.edit');                    //编辑


###其他命令
- 生成默认控制器controller


    php artisan make:jkd-controller Admin/CryController
    
- 生成默认模型model


    php artisan make:jkd-model Cry
    
- 生成默认资源库repository

    
    php artisan make:jkd-repository Admin/CryRepository
    
- 生成默认验证器request


    php artisan make:jkd-request Admin/CryPost
    
- 生成默认js文件


    php artisan make:jkd-js admin/cry
    
- 生成默认视图add / index


    php artisan make:jkd-add admin/cry
    php artisan make:jkd-index admin/cry
                
- 生成默认数据迁移migration

    
    php artisan make:jkd-table cry
    
    
###.env 配置
    #百度搜索平台
    BAIDU_SITE_URL="BAIDU_SITE_URL"
    
    #方糖推送
    FANGTANG_KEY="FANGTANG_KEY"
    
    #定时任务请求每日一句的基本信息
    CATEGORY_ID=CATEGORY_ID
    USER_ID=USER_ID
    AUTHOR="AUTHOR"
    
    #图片添加水印 不启动则修改成false
    IS_ADD_WATER=true
    
    #水印文字 IS_ADD_WATER为true时填写
    TOP_WATER="TOP_WATER"
    BOTTOM_WATER="BOTTOM_WATER"
    
    #七牛
    FILESYSTEM_CLOUD=qiniu
    QINIU_ACCESS_KEY=QINIU_ACCESS_KEY
    QINIU_SECRET_KEY=QINIU_SECRET_KEY
    QINIU_BUCKET=QINIU_BUCKET
    QINIU_URL=QINIU_URL
