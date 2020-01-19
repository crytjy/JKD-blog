<?php

namespace App\Http\ViewComposers;

//use Auth;
use Illuminate\View\View;

class AdminComposer
{
    protected $menu;
    protected $adminIndex;
    public function __construct()
    {
//        $user = Auth::guard()->user();
//        $user_id = $user ? $user->id : 0;

        $menuData = config('menu');
        $this->menu = $menuData['adminRoute'];
        $this->adminIndex = $menuData['adminIndex'];
    }


    public function compose(View $view)
    {
        if($this->adminIndex != $_SERVER['REQUEST_URI']){
            list($preUri, $jkdUri) = explode($this->adminIndex, $_SERVER['REQUEST_URI']);
            $topUri = explode('/', $jkdUri)[0] ?: $jkdUri;
        }

        $view->with([
            'menu' => $this->menu,
            'jkdUri' => $jkdUri ?? '',
            'topUri' => $topUri ?? ''
        ]);
    }

}
