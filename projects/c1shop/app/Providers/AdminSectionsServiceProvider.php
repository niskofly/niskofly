<?php

namespace App\Providers;

use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminSectionsServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $sections = [
        //\App\User::class => 'App\Http\Sections\Users',
        \App\Models\FundamentalSetting::class => 'App\Http\Sections\fundamentalSettings',
        \App\Models\CompletedProject::class => 'App\Http\Sections\completedProjects',
        \App\Models\Categorie::class => 'App\Http\Sections\categories',
        \App\Models\ChildCategorie::class => 'App\Http\Sections\childCategories',
        \App\Models\Article::class => 'App\Http\Sections\articles',
        \App\Models\Brand::class => 'App\Http\Sections\brands',
        \App\Models\Customer::class => 'App\Http\Sections\customers',
        \App\Models\Contact::class => 'App\Http\Sections\contact',
        \App\Models\ReadyMadeProject::class => 'App\Http\Sections\readyMadeProject',
        \App\Models\Sertificate::class => 'App\Http\Sections\sertificate',
        \App\Models\Product::class => 'App\Http\Sections\product',
        \App\Models\Filter::class => 'App\Http\Sections\filter',
        \App\Models\Share::class => 'App\Http\Sections\shares',
        \App\Models\Napravlenie::class => 'App\Http\Sections\Napravlenies',
        \App\Models\SeoFilter::class => 'App\Http\Sections\SeoFilters',
        \App\Models\Brochure::class => 'App\Http\Sections\brochures',
        \App\Models\City::class => 'App\Http\Sections\Cities',
        \App\Models\Review::class => 'App\Http\Sections\ReviewSection',
        \App\Models\Part::class => 'App\Http\Sections\parts',
    ];

    /**
     * Register sections.
     *
     * @return void
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {
        parent::boot($admin);
    }
}
