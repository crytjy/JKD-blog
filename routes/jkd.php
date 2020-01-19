<?php

use  App\Models\AutoRoute;

Auth::routes();
Auth::routes(['register' => false]);

Route::group(['prefix' => 'jkd', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'IndexController@index')->name('jkd');   //首页
    Route::post('uploadEditFile', 'UploadController@uploadEditFile')->name('uploadEditFile');   //富文本图片上传

    $routes = AutoRoute::getAutoRoute();
    if ($routes) {
        foreach ($routes as $route) {
            $name = $route['name'];
            $conName = $route['controller_name'];
            Route::get($name, $conName . '@index')->name($name);  //列表首页
            Route::get($name . '/pageQuery', $conName . '@pageQuery')->name($name . '.pageQuery');
            Route::get($name . '/edit', $conName . '@edit')->name($name . '.edit');
            Route::post($name . '/destroy', $conName . '@destroy')->name($name . '.destroy');
            Route::post($name . '/store', $conName . '@store')->name($name . '.store');
            Route::post($name . '/update', $conName . '@update')->name($name . '.update');
        }
    }

    //用户管理
    Route::get('user', 'UserController@index')->name('user');  //用户列表首页
    Route::get('user/pageQuery', 'UserController@pageQuery')->name('user.pageQuery');
    Route::post('user/destroy', 'UserController@destroy')->name('user.destroy');


    //随言碎语
    Route::get('chat', 'ChatController@index')->name('chat');  //列表首页
    Route::get('chat/pageQuery', 'ChatController@pageQuery')->name('chat.pageQuery');
    Route::post('chat/destroy', 'ChatController@destroy')->name('chat.destroy');
    Route::post('chat/store', 'ChatController@store')->name('chat.store');
    Route::post('chat/update', 'ChatController@update')->name('chat.update');
    Route::get('chat/edit', 'ChatController@edit')->name('chat.edit');


    //标签
    Route::get('tag', 'TagController@index')->name('tag');  //列表首页
    Route::get('tag/pageQuery', 'TagController@pageQuery')->name('tag.pageQuery');
    Route::post('tag/destroy', 'TagController@destroy')->name('tag.destroy');
    Route::post('tag/store', 'TagController@store')->name('tag.store');
    Route::post('tag/update', 'TagController@update')->name('tag.update');
    Route::get('tag/edit', 'TagController@edit')->name('tag.edit');


    //分类
    Route::get('category', 'CategoryController@index')->name('category');  //列表首页
    Route::get('category/pageQuery', 'CategoryController@pageQuery')->name('category.pageQuery');
    Route::post('category/destroy', 'CategoryController@destroy')->name('category.destroy');
    Route::post('category/store', 'CategoryController@store')->name('category.store');
    Route::post('category/update', 'CategoryController@update')->name('category.update');
    Route::get('category/edit', 'CategoryController@edit')->name('category.edit');
    Route::post('category/batchUpdate', 'CategoryController@batchUpdate')->name('category.batchUpdate');


    //友链
    Route::get('link', 'LinkController@index')->name('link');  //列表首页
    Route::get('link/pageQuery', 'LinkController@pageQuery')->name('link.pageQuery');
    Route::post('link/destroy', 'LinkController@destroy')->name('link.destroy');
    Route::post('link/store', 'LinkController@store')->name('link.store');
    Route::post('link/update', 'LinkController@update')->name('link.update');
    Route::get('link/edit', 'LinkController@edit')->name('link.edit');
    Route::post('link/batchUpdate', 'LinkController@batchUpdate')->name('link.batchUpdate');


    //文章
    Route::get('article', 'ArticleController@index')->name('article');  //列表首页
    Route::get('article/pageQuery', 'ArticleController@pageQuery')->name('article.pageQuery');
    Route::post('article/destroy', 'ArticleController@destroy')->name('article.destroy');
    Route::post('article/store', 'ArticleController@store')->name('article.store');
    Route::post('article/update', 'ArticleController@update')->name('article.update');
    Route::get('article/edit', 'ArticleController@edit')->name('article.edit');





});
