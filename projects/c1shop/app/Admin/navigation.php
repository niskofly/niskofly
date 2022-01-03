<?php

use SleepingOwl\Admin\Navigation\Page;

// Default check access logic
// AdminNavigation::setAccessLogic(function(Page $page) {
// 	   return auth()->user()->isSuperAdmin();
// });
//
// AdminNavigation::addPage(\App\User::class)->setTitle('test')->setPages(function(Page $page) {
// 	  $page
//		  ->addPage()
//	  	  ->setTitle('Dashboard')
//		  ->setUrl(route('admin.dashboard'))
//		  ->setPriority(100);
//
//	  $page->addPage(\App\User::class);
// });
//
// // or
//
// AdminSection::addMenuPage(\App\User::class)

return [
    [
        'title' => "Категории продукции",
        'icon' => 'fa fa-th',
        'priority' => 0,
        'pages' => [
            (new Page(\App\Models\Categorie::class))
                ->setIcon('fa fa-list')
                ->setPriority(0),
            (new Page(\App\Models\ChildCategorie::class))
                ->setIcon('fa  fa-list-ol')
                ->setPriority(1),
            (new Page(\App\Models\Brand::class))
                ->setIcon('fa fa-product-hunt')
                ->setPriority(2),
        ]
    ],
    [
        'title' => "Фильтры",
        'icon' => 'fa fa-filter',
        'priority' => 1,
        'pages' => [
            (new Page(\App\Models\Filter::class))
                ->setIcon('')
                ->setPriority(0),
            (new Page(\App\Models\Napravlenie::class))
                ->setIcon('')
                ->setPriority(1),
        ]
    ],
    [
        'title' => "Новостной контент",
        'icon' => 'fa fa-newspaper-o',
        'priority' => 4,
        'pages' => [
            (new Page(\App\Models\Article::class))
                ->setIcon('fa fa-newspaper-o')
                ->setPriority(0),
            (new Page(\App\Models\Share::class))
                ->setIcon('fa fa-newspaper-o')
                ->setPriority(1),
        ]
    ],

    [
        'title' => 'Экспорты',
        'icon' => 'fa fa-download',
        'priority' => 30,
        'pages' => [
            [
                'title' => 'Экспорт в YML',
                'icon' => 'fa fa-download',
                'priority' => 30,
                'url' => '/export-yml',
            ],
            [
                'title' => 'Экспорт в Turbo YML',
                'icon' => 'fa fa-download',
                'priority' => 31,
                'url' => '/export-turbo-yml',
            ]
        ],
    ],
];
