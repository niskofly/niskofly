<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Categorie;
use App\Models\ChildCategorie;
use App\Models\Article;
use App\Models\Filter;
use App\Models\Part;
use App\Models\ReadyMadeProject;
use App\Models\Product;

use App\Models\Share;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    protected $widgets = [
        \Admin\Widgets\NavigationHeaderBlock::class
    ];
    public function boot()
    {
        $widgetsRegistry = $this->app[\SleepingOwl\Admin\Contracts\Widgets\WidgetsRegistryInterface::class];

        foreach ($this->widgets as $widget) {
            $widgetsRegistry->registerWidget($widget);
        }

        View::share('socials', config('app.socials'));

        Categorie::updating(function ($model_request) {
            //return $model_request->url = str_slug($model_request->name);
        });

        Categorie::creating(function ($model_request) {
            return $model_request->url = str_slug($model_request->name);
        });



        ChildCategorie::updating(function ($model_request) {

            if ( $model_request->parent_category == "10"){
                return $model_request->url = $model_request->type;
            }else{
                return true;
            }
        });

        ChildCategorie::creating(function ($model_request) {
            if ( $model_request->parent_category == "10"){
                return $model_request->url = $model_request->type;
            }else{
                return true;
            }
        });



        Article::updating(function ($model_request) {
            return $model_request->url = str_slug($model_request->name);
        });

        Article::creating(function ($model_request) {
            return $model_request->url = str_slug($model_request->name);
        });

        Share::updating(function ($model_request) {
            return $model_request->url = str_slug($model_request->name);
        });

        Share::creating(function ($model_request) {
            return $model_request->url = str_slug($model_request->name);
        });

        Brand::updating(function ($model_request) {
            return $model_request->url = str_slug($model_request->name);
        });

        Brand::creating(function ($model_request) {
            $img = \Intervention\Image\Facades\Image::make($model_request->photo);
            $model_request->url = str_slug($model_request->name);
            $model_request->default_img = $img->basename;
            return $model_request;
        });

        Product::updating(function ($model_request) {
            if (isset($_POST['params'])) {
                $resultParams = [];
                $category_id = 0;
                foreach ($_POST['params'] as $category_name => $items) {
                    $resultParams[$category_id] = [
                        'id' => $category_id,
                        'name' => $category_name
                    ];
                    $item_id = 0;
                    foreach ($items as $key => $param) {
                        $resultParams[$category_id]['items'][] = [
                            'id' => $item_id,
                            'name' => (string)$param['name'],
                            'value' => (string)$param['value'],
                        ];
                        $item_id++;
                    }
                    $category_id++;
                }


                $model_request->params = serialize($resultParams);
            }
            if($model_request->photo) {
                $img = \Intervention\Image\Facades\Image::make($model_request->photo);
                $model_request->default_img = $img->basename;
            }

            $model_request->url = str_slug($model_request->name);

            return $model_request;
        });

        Product::creating(function ($model_request) {

           if (isset($_POST['params'])) {
               $resultParams = [];
               $category_id = 0;
               foreach ($_POST['params'] as $category_name => $items) {
                   $resultParams[$category_id] = [
                       'id' => $category_id,
                       'name' => $category_name
                   ];
                   $item_id = 0;
                   foreach ($items as $key => $param) {
                       $resultParams[$category_id]['items'][] = [
                           'id' => $item_id,
                           'name' => (string)$param['name'],
                           'value' => (string)$param['value'],
                       ];
                       $item_id++;
                   }
                   $category_id++;
               }

               $model_request->params = serialize($resultParams);

           }
            return $model_request->url = str_slug($model_request->name);
        });


        Part::updating(function ($model_request) {
            $paramsName = $_POST['params']['name'];
            $paramsValue = $_POST['params']['value'];
            $resultParams = [];
            foreach ($paramsName as $key => $paramName) {
                if ($paramName != null && $paramsValue[$key] != null) {
                    $resultParams[] = array(
                        'name' => $paramName,
                        'value' => $paramsValue[$key],
                    );
                }
            }

            $model_request->params = serialize($resultParams);
            if($model_request->photo) {
                $img = \Intervention\Image\Facades\Image::make($model_request->photo);
                $model_request->default_img = $img->basename;
            }

            $model_request->url = str_slug($model_request->name);

            return $model_request;
        });

        Part::creating(function ($model_request) {
            $paramsName = $_POST['params']['name'];
            $paramsValue = $_POST['params']['value'];
            $resultParams = [];

            foreach ($paramsName as $key => $paramName) {
                if ($paramName != null && $paramsValue[$key] != null) {
                    $resultParams[] = array(
                        'name' => $paramName,
                        'value' => $paramsValue[$key],
                    );
                }
            }

            $model_request->params = serialize($resultParams);
            return $model_request->url = str_slug($model_request->name);
        });



        ReadyMadeProject::updating(function ($model_request) {

            $paramsName = $model_request->params['name'];
            $paramsValue = $model_request->params['value'];
            $resultParams = [];

            foreach ($paramsName as $key => $paramName){
                if($paramName != null && $paramsValue[$key] != null){
                    $resultParams[] = array(
                        'name' => $paramName,
                        'value' => $paramsValue[$key],
                    );
                }
            }

            return $model_request->params = serialize($resultParams);
        });

        ReadyMadeProject::creating(function ($model_request) {
            $paramsName = $model_request->params['name'];
            $paramsValue = $model_request->params['value'];
            $resultParams = [];

            foreach ($paramsName as $key => $paramName){
                if($paramName != null && $paramsValue[$key] != null){
                    $resultParams[] = array(
                        'name' => $paramName,
                        'value' => $paramsValue[$key],
                    );
                }
            }

            return $model_request->params = serialize($resultParams);
        });

        /**
         * Paginate a standard Laravel Collection.
         *
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
