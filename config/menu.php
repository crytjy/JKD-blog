<?php

return [
    'adminIndex' => '/jkd',
    'adminRoute' => [
        [
            'name' => '用户管理',
            'icon' => 'fa-user',
            'routePrefix' => ['/user'],
            'children' => [
                [
                    'name' => '用户中心',
                    'route' => 'user'
                ],
            ]
        ],
        [
            'name' => '随言碎语',
            'icon' => 'fa-sticky-note',
            'routePrefix' => ['/chat'],
            'children' => [
                [
                    'name' => '随言碎语',
                    'route' => 'chat'
                ],
            ]
        ],
        [
            'name' => '内容管理',
            'icon' => 'fa-book',
            'routePrefix' => ['/tag', '/category'],
            'children' => [
                [
                    'name' => '文章管理',
                    'route' => 'article'
                ],
                [
                    'name' => '标签管理',
                    'route' => 'tag'
                ],
                [
                    'name' => '分类管理',
                    'route' => 'category'
                ],
            ]
        ],
        [
            'name' => '友链管理',
            'icon' => 'fa-link',
            'routePrefix' => ['/link'],
            'children' => [
                [
                    'name' => '友情链接',
                    'route' => 'link'
                ],
            ]
        ],
    ]
];