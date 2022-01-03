<?php

namespace App\Http\Controllers;


use App\Models\Categorie;
use App\Models\ChildCategorie;
use App\Models\City;
use App\Models\Filter;
use App\Models\Product;
use App\Models\Share;
use Sitemap;
use Illuminate\Http\Request;

class SitemapsController extends MainController
{
    private $domain = 'https://www.laundrypro.ru/';
    private $changefreq = 'monthly';
    private $priority = '0.5';

    public function index(Request $request)
    {
        // Генерация статических страниц
        Sitemap::addSitemap(route('sitemap_pages'));
        Sitemap::addSitemap(route('sitemap_filters'));

        // Генерация ссылок карты сайтов по городам
        $this->cities = City::where('id', '!=', 3)->published()->get();
        foreach ($this->cities as $city) {
            Sitemap::addSitemap($this->domain . "sitemap{$city->code}.xml");
        }

        return Sitemap::index();

    }

    /**
     * Генерация ссылок страниц
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function generateFromPages(Request $request)
    {
        // статические страницы (должны быть именованными роутами с префиксом 'pages-' (напр. 'pages-privacy')
        Sitemap::addSitemap($this->manualMap());

        Sitemap::addSitemap($this->articles());
        Sitemap::addSitemap($this->shares());

        Sitemap::addSitemap($this->products());
        Sitemap::addSitemap($this->categories());
        Sitemap::addSitemap($this->childCategories());
        //Sitemap::addSitemap($this->getFilterPages());

        return Sitemap::render();

    }

    public function generateFromCity(Request $request)
    {
        $this->city = City::where('code',  $request->code)->published()->first();
        if(!$this->city) {
            return abort(404);
        }
        Sitemap::addSitemap($this->products());
        Sitemap::addSitemap($this->categories());
        Sitemap::addSitemap($this->childCategories());

        return Sitemap::render();
    }

    public function page(Request $request)
    {
        $this->seoParams['title'] = 'Карта сайта | Компания «Вектор» ';
        $this->seoParams['description'] = 'Карта сайта компании «Вектор» - удобная навигация по каталогу прачечного оборудования. ';
        parent::index($request);

        return view('pages/sitemap', [
            'menuCategories' => Categorie::All()
        ]);
    }



    //----------------------------------------------
    // Вспомогательные функции
    //----------------------------------------------
    public function articles()
    {
        $articles = \App\Models\Article::all();

        foreach ($articles as $article) {
            Sitemap::addTag($this->domain . 'article/' . $article->url, null, $this->changefreq, $this->priority);
        }

        return Sitemap::render();
    }

    public function shares()
    {
        $shares = Share::all();

        foreach ($shares as $share) {
            Sitemap::addTag($this->domain . 'share/' . $share->url, null, $this->changefreq, $this->priority);
        }

        return Sitemap::render();
    }

    public function products()
    {
        $products = Product::All();

        if (isset($this->city)) {
            $city_url = $this->city->code . '/';
            foreach ($products as $product) {
                Sitemap::addTag($this->domain . 'catalog/' . $city_url . $product->category()->url . '/' . $product->url, null, $this->changefreq, $this->priority);
            }
        } else {
            foreach ($products as $product) {
                Sitemap::addTag($this->domain . 'catalog/' . $product->category()->url . '/' . $product->url, null, $this->changefreq, $this->priority);
            }
        }

        return Sitemap::render();
    }

    // не очень удачно реализована взаимосвязь с частью url "/catalog/"
    // обработка исключений
    //      katalog-produktsii id = 18
    //      zapchasti
    public function categories()
    {
        $categories = Categorie::All();

        if (isset($this->city)) {
            $city_url = $this->city->code . '/';
            foreach ($categories as $category) {
                switch ($category->id) {
                    case 18:
                        Sitemap::addTag($this->domain . 'catalog/' . $city_url, null, $this->changefreq, $this->priority);
                        break;
                    case 10:
                        Sitemap::addTag($this->domain . $category->url, null, $this->changefreq, $this->priority);
                        break;
                    default:
                        Sitemap::addTag($this->domain . 'catalog/' . $city_url . $category->url, null, $this->changefreq, $this->priority);
                }
            }
        } else {
            foreach ($categories as $category) {
                switch ($category->id) {
                    case 18:
                        Sitemap::addTag($this->domain . 'catalog/', null, $this->changefreq, $this->priority);
                        break;
                    case 10:
                        Sitemap::addTag($this->domain . $category->url, null, $this->changefreq, $this->priority);
                        break;
                    default:
                        Sitemap::addTag($this->domain . 'catalog/' . $category->url, null, $this->changefreq, $this->priority);
                }
            }
        }

        return Sitemap::render();
    }


    public function childCategories()
    {
        $childCategories = ChildCategorie::All();

        if (isset($this->city)) {
            $city_url = $this->city->code . '/';
            foreach ($childCategories as $childCategory) {
                Sitemap::addTag($this->domain . 'catalog/' . $city_url . $childCategory->parentCategory()->url . '/type-' . $childCategory->url, null, $this->changefreq, $this->priority);
            }
        } else {
            foreach ($childCategories as $childCategory) {
                Sitemap::addTag($this->domain . 'catalog/' . $childCategory->parentCategory()->url . '/type-' . $childCategory->url, null, $this->changefreq, $this->priority);
            }
        }

        return Sitemap::render();
    }

    /**
     * Статические страницы.
     */
    public function manualMap()
    {
        Sitemap::addTag($this->domain . '', null, 'weekly', '1.0');

        $pages = $this->getStaticPages();
        foreach ($pages as $page) {
            Sitemap::addTag(route($page), null, $this->changefreq, $this->priority);
        }
    }

    /**
     * Список статических страниц.
     *
     * @return array
     */
    public function getStaticPages()
    {
        $pages = array();
        $routes = \Route::getRoutes();
        foreach ($routes->getIterator() as $route) {
            if (isset($route->action) && !empty($route->action['as'])) {
                if (preg_match('/^(pages-)/', $route->action['as'])) {
                    $pages[] = $route->action['as'];
                }
            }
        }
        return $pages;
    }

    public function getFilterPages()
    {
        $categories = Categorie::All();
        foreach ($categories as $category) {
            $variants = Filter::GetAllVariantFilter($category->id);
            $filter = '';
            foreach ($variants as $v => $variant) {
                foreach ($variant as $i => $item) {
                    $filter = $v . '-' . $i;
                    /**
                     * Пропускаем ссылки на категории второго уровня
                     */
                    if($v == 'type')
                        continue;
                    $url = $this->domain . 'catalog/' . $category->url . '/' . $filter;
                    Sitemap::addTag($url, null, $this->changefreq, $this->priority);
                }
            }
        }
        return Sitemap::render();
    }
}