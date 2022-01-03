<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\ChildCategorie;
use App\Models\City;
use App\Models\Filter;
use App\Models\Part;
use App\Models\Product;
use App\Models\Share;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class CatalogPartsController extends MainController
{
    protected $request;
    protected $products__storage;
    protected $activeFilters = [];
    protected $category = false;
    protected $binding_filters = [];
    protected $children_category = false;
    protected $all_parameter_filter  = [];

    protected $filters_url;
    protected $filters_render = [];
    protected $filters_active = [];
    protected $filters_products = [];
    protected $categories_by_brand = [];

    protected $products_render;
    protected $city = false;
    protected $city_url = false;

    protected $filters_types;
    protected $filters_types_active = [];

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */




    /**
     * Переключение городов.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function switch_content_city(Request $request)
    {
        $this->request = $request;
        $category_url = Route::input('category_parts');

        $this->city = City::getSelectCity();
        $request_city = City::where('code', Route::input('city'))->published()->first();

        // Если нет города в запросе, но выбран город
        if ((is_null($request_city) && $this->city)) {
            Route::current()->setParameter('type', Route::current()->parameter('catalog-parts'));
            Route::current()->setParameter('catalog-parts', Route::current()->parameter('city'));
            Route::current()->setParameter('city', $this->city->code);
            return redirect()->route('catalog-parts', Route::current()->parameters);
        }
        // Если не определен город в запросе
        if (!$request_city) {
            $category_url = Route::input('city');
        }

        // Если есть город в запросе и выбран город
        if ($request_city && $this->city) {
            // Если город в запросе и выбранный не совпадают
            if ($request_city->id !== $this->city->id) {
                Route::current()->setParameter('city', $this->city->code);
                // Редирект на каталог с выбранным городом
                return redirect()->route('catalog-parts', Route::current()->parameters);
            }
        }
        // Если есть город в запросе, но не выбран
        if ($request_city && !$this->city) {
            $this->city = $request_city;
        }

        $type_filter = explode('-', $category_url);
        $is_set_filter = Filter::where([
            ['type_filter', '=', $type_filter[0]],
            ['value', '=', str_replace($type_filter[0] . '-', '', $category_url)]
        ])->first();




        if (!$category_url || $is_set_filter) {
            return $this->render__catalog();
        } else {

            $this->category = ChildCategorie::where('url', $category_url)->first();

            if (!$this->category) {

                $this::get404();
            }

            $is_napravlenie = $this->category->napravlenie ? true : false;
            $is_brand = $this->category->brands ? true : false;

            if ($is_napravlenie) {
                return $this->render_napravlenie();
            }

            if ($is_brand) {
                return $this->render__brand();
            }

            if ($this->category) {
                if ($this->category->id == 11) {
                    return $this->render_in_stock();
                }

                return $this->render__category();
            }
        }
        //dd($this->products__storage->FilterProduct($this->activeFilters)->paginate(16));
    }

    /**
     * Рендер категории.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function render__category()
    {

        $parts_category = $this->category->category_parts()->get();

        $parts_additional_category = $this->category->parentCategory()->additional_parts;

        $productsAll = $this->get_collapsed_collecton([$parts_category, $parts_additional_category]);
        //$productsAll = Part::active()->get();


        $this->binding_filters = unserialize($this->category->parentCategory()->binding_filters) ? unserialize($this->category->parentCategory()->binding_filters) : [0 => 'mark'];

        $this->filters_url = $this->get_filters_by_products($productsAll, true);

        $this->filters_render = $this->get_filters_by_render($productsAll);

        $this->filters_active = $this->get_selected_filters();

        $this->all_parameter_filter = $this->get_filters_by_render(Part::active()->get(), false);



        if (count($this->request->route()->parameters) > 1
            && count($this->filters_active) == 0
            && !$this->city || count($this->request->route()->parameters) > 2
            && count($this->filters_active) == 0 && $this->city) {

            return $this->render_product();
        }

        if (get_class($this->category) === 'App\Models\Categorie') {
            $products_category__filtered = $this->category->parentCategory()->parts()->where($this->filters_active)->get();

            $products_additional__filtered = $this->category->parentCategory()->additional_parts()->where($this->filters_active)->get();
        }else{

            $products_category__filtered = $this->category->category_parts()->where($this->filters_active)->get();

            $products_additional__filtered = [];
        }


        if (get_class($this->category) !== 'App\Models\Categorie') {
            $products_filtered = $this->get_collapsed_collecton([$products_category__filtered, $products_additional__filtered, $this->category->category_parts()]);

        }else{
            $products_filtered = $this->get_collapsed_collecton([$products_category__filtered, $products_additional__filtered]);

        }



        $products_ids = [];
        foreach ($products_filtered as $product) {
            $products_ids[$product->id] = $product->id;
        }
        //dd($products_ids);
        $this->products_render = Part::whereIn('id', $products_ids)->active()->paginate(16);

        return $this->render();
    }

    protected function get_collapsed_collecton($collections)
    {
        $products = [];
        $collection = collect([]);
        foreach ($collections as $collect) {

            $collection->push($collect);
        }


        $collapsed = $collection->collapse();
        $products = $collapsed->all();
        return $products;
    }


    /**
     * @param $products
     * @return array  ["type_filter" => ["url_filter" => "url_filter", ...], ...]
     */
    protected function get_filters_by_products($products, $filtered_products)
    {

        $filters = [];
        $products = collect($products);

        if (count($this->filters_active) > 0 && $filtered_products) {
            foreach ($this->filters_active as $key => $value) {
                $products = $products->where($key, $value);
            }
        }

        if (count($products) > 0) {
            foreach ($products as $product) {
                foreach ($this->binding_filters as $filter) {
                    $filters[$filter][$product->$filter] = $product->$filter;
                }
            }
        }
        return $filters;
    }


    /**
     * @param $products
     * @return array ["type_filter" => ["url_filter" => Filter::class, ...], ...]
     */
    protected function get_filters_by_render($products)
    {

        $filters = [];
        if (count($this->binding_filters) > 0) {

            if (get_class($this->category) === 'App\Models\Categorie') {
                $info_filters = Filter::GetAllVariantFilter($this->category->id);
            }else{
                $info_filters = Filter::GetAllVariantFilter($this->category->parentCategory()->id);
            }

            if (count($products) > 0) {
                foreach ($products as $product) {
                    foreach ($this->binding_filters as $filter) {

                        if (isset($info_filters[$filter][$product->$filter])) {
                            $filters[$filter][$product->$filter] = $info_filters[$filter][$product->$filter];
                        }
                    }
                }
            }
        }


        return $filters;
    }


    protected function get_selected_filters()
    {
        $filters = [];
        $route_parameter = $this->request->route()->parameters;

        foreach ($route_parameter as $filter) {

            // фильтр марка
            if (starts_with($filter, 'mark-')) {
                $filters['mark'] = $this->check_filter($filter, 'mark');
            }


//            // фильтр наличия на складе
//            if (starts_with($filter, 'in-stock')) {
//                $this->arActiveFilter['in_stock'] = 1;
//            }

            // фильтр тип оборудования
            if (starts_with($filter, 'type-')) {
                $filters['type'] = $this->check_filter($filter, 'type');
            }

            // фильтр растворители
            /*if (starts_with($filter, 'solvent-')) {
                $filters['solvent'] = $this->check_filter($filter, 'solvent');
            }*/
        }

        if (count($route_parameter) != count($filters) && !$this->category) {
            $this::get404();
        }
        return $filters;
    }

    /**
     * Рендер товара.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function render_product()
    {

        $product_url = $this->city ? $this->request->route()->parameters['type1'] : $this->request->route()->parameters['category_parts'];

        $product = Part::GetPart($product_url, $this->category->parentCategory()->id);

        if (empty($product->id)) {
            $this::get404();
        }

        if ($product->actual_price == 0) {
            $price = ' по запросу ';
        } else {
            $price = number_format($product->actual_price, 0, "", " ") . ' р. ';
        }

        if (isset($product->mark)) {
            $mark = explode(' ', $product->filterMark()->name);
        }

        $this->seoParams['title'] = $product->seo_title ? $product->seo_title : $product->name . ' ' . $mark[0] . ' - цена ' . $price;


        if (isset($product->seo_description)) {
            $this->seoParams['description'] = $product->seo_description;
        } else {
            $productDescription = $product->name;


            $this->seoParams['description'] = $productDescription;
        }

        $this->seoParams['image'] = $product->photo;

        $city_url = '';
        $city_code = '';
        if ($this->city) {
            $city_code = $this->city->code;
            $city_url = $this->city->code . '/';
            $this->seoParams['title'] = $this->seoParams['title'] . ' ' . $this->city->seo_part;
            $this->seoParams['description'] = $this->seoParams['description'] . ' ' . $this->city->seo_part;
        }

        parent::index($this->request);





        if (count($product) > 0) {
            return view('pages.part.index', [
                'Category' => $this->category,
                'ChildCategory' => ChildCategorie::findCategoryByUrl($product->type),
                'Product' => $product,

                'AllParameterFilter' => $this->filters_products,
                'filter' => new Filter(),
                'binding_filters' => $this->binding_filters,

                'city_code' => $city_code,
                'city_url' => $city_url,
                'city_selected' => City::getSelectCityFromFromUI(),
            ]);
        } else {
            $this::get404();
        }
    }





    /**
     * Рендер каталога.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function render__catalog()
    {

        $this->category = Categorie::where('url', 'zapchasti')->first();

        $productsAll = Part::where(['active' => 1])->get();


        $this->binding_filters = unserialize($this->category->binding_filters) ? unserialize($this->category->binding_filters) : [];
        $this->filters_url = $this->get_filters_by_products($productsAll, false);
        $this->filters_render = $this->get_filters_by_render($productsAll);

        $this->filters_active = $this->get_selected_filters();
        $this->filters_url = $this->get_filters_by_products($productsAll, true);

        $this->products_render = Part::active()->where($this->filters_active)->active()->paginate(16);


        return $this->render();
    }


    protected function render($is_no_add_url_category = false)
    {

        if ($this->request->input('page') == 1) {
            return redirect(\URL::current(), 301);
        }

        $this->seoParams['description'] = '';
        $this->seoParams['title'] = isset($this->category->seo_title) ? $this->category->seo_title : $this->category->name;
        $this->seoParams['description'] = isset($this->category->seo_description) ? $this->category->seo_description : '';

        $is_seo_children_category = false;
        if ($this->children_category && count($this->filters_active) == 1) {
            $is_seo_children_category = true;
            $this->seoParams['title'] = $this->children_category->seo_title ? $this->children_category->seo_title : $this->seoParams['title'];
            $this->seoParams['description'] = $this->children_category->seo_description ? $this->children_category->seo_description : $this->seoParams['description'];
            $this->category->name = $this->children_category->name;
            $this->category->seo_h1 = $this->children_category->seo_h1;
            $this->category->seo_h2 = $this->children_category->seo_h2;
            $this->category->description = $this->children_category->description;
            $this->category->top_description = $this->children_category->top_description;
        }


        $filter_str_parameter = '';
        $mark_seo = '';
        $sub_category = $this->category;

        if (count($this->filters_active) > 0 && !$is_seo_children_category) {
            $title_filter = '';
            $description_filter = '';
            $napravlenie_name = '';
            $mark = false;
            if (!$is_seo_children_category) {
                $this->category->seo_h2 = '';
                $this->category->description = '';
                $this->category->top_description = '';
                $this->category->seo_h1 = 'qwe';
            }

            foreach ($this->filters_active as $key => $filter) {

                switch ($key) {
                    case 'mark':
                        $mark = array_get($this->filters_render, 'mark.' . $filter);
                        $mark_seo = " марки " . $mark->name;
                        break;
                    case 'type':
                        $sub_category = ChildCategorie::where('url', $filter)->first();
                        if ($this->category->napravlenie) {
                            $napravlenie_name = mb_strtolower($this->category->napravlenie->name);
                            $napravlenie_name = str_replace('оборудование', '', $napravlenie_name);
                            $napravlenie_name = ' ' . $napravlenie_name . ' ';
                        }
                        break;
                    case 'series':
                        $series = array_get($this->filters_render, 'series.' . $filter);
                        $filter_str_parameter .= ' серии ' . $series->name;
                        break;
                }
            }

            if (!$is_seo_children_category) {
                $this->category->seo_h2 = '';
                $this->category->description = '';
                $this->category->top_description = '';
                $this->category->seo_h1 = $sub_category->name . $napravlenie_name . $mark_seo . $filter_str_parameter;
            }

            if (count($this->filters_active) == 1 && $mark) {
                if ($this->category->seo_title_brand) {
                    $title_filter = preg_replace('/#BRAND#/', $mark->name, $this->category->seo_title_brand);
                }
                if ($this->category->seo_description_brand) {
                    $description_filter = preg_replace('/#BRAND#/', $mark->name, $this->category->seo_description_brand);
                }
            } else {
                $title_filter = "Купить " . mb_strtolower($sub_category->name) . $napravlenie_name . $mark_seo . $filter_str_parameter . "";
                $description_filter = "" . $sub_category->name . $napravlenie_name . $mark_seo . $filter_str_parameter . " недорого заказать с доставкой";
            }


            if ($title_filter) {
                $this->seoParams['title'] = $title_filter;
            }

            if ($description_filter) {
                $this->seoParams['description'] = $description_filter;
            }

            if (count($this->filters_active) == 1 && array_key_exists("in_stock", $this->filters_active)) {
                $this->seoParams['title'] = 'Прачечное оборудование в наличии на складе | Компания Вектор';
                $this->seoParams['description'] = 'Прачечное оборудование имеющиеся в наличии на складе благодаря прямым поставкам с завода, быстрая доставка с нашего склада с минимальным временем ожидания.';
            }
        }

        if (!$this->products_render->onFirstPage()) {
            $this->seoParams['canonical'] = \URL::current();
        }

        // вырезаем лишнее из информации о разделе
        if (array_key_exists('loading', $this->filters_render)) {
            asort($this->filters_render['loading']);
        }

        if (array_key_exists('performance', $this->filters_render)) {
            asort($this->filters_render['performance']);
        }

        if (array_key_exists('width_area', $this->filters_render)) {
            asort($this->filters_render['width_area']);
        }

        if (array_key_exists('solvent', $this->filters_render)) {
            asort($this->filters_render['solvent']);
        }

        // вывод seo описания для фильтра
        $seo_article_parameter = [
            'type' => null,
            'mark' => null,
            'series' => null,
            'loading' => null,
            'width_area' => null,
            'performance' => null,
            'solvent' => null,
        ];

        foreach ($seo_article_parameter as $key => $parameter) {
            if (isset($this->filters_active[$key]))
                $seo_article_parameter[$key] = $this->filters_active[$key];
        }
        if (get_class($this->category) === 'App\Models\Categorie'){
            $seo_filter = $this->category->seo_filter()->active()->where($seo_article_parameter)->first();
        }else{
            $seo_filter = $this->category->parentCategory()->seo_filter()->active()->where($seo_article_parameter)->first();
        }


        if ($seo_filter && count($this->filters_active) <= count($seo_article_parameter)) {
            $this->category->description = $seo_filter->description;
            $this->category->seo_h1 = $seo_filter->seo_h1;
            $this->category->seo_h2 = $seo_filter->seo_h2;
        }
        // end вывод seo описания для фильтра

        if ($this->city) {
            $this->seoParams['title'] = $this->seoParams['title'] . ' ' . $this->city->seo_part;
            $this->seoParams['description'] = $this->seoParams['description'] . ' ' . $this->city->seo_part;
            $this->category->description = preg_replace('/#CITY#/', $this->city->seo_part, $this->category->description);
            $this->category->top_description = preg_replace('/#CITY#/', $this->city->seo_part, $this->category->top_description);
            $this->category->seo_h2 = preg_replace('/#CITY#/', $this->city->seo_part, $this->category->seo_h2);
        } else {
            $this->category->description = preg_replace('/#CITY#/', '', $this->category->description);
            $this->category->top_description = preg_replace('/#CITY#/', '', $this->category->top_description);
            $this->category->seo_h2 = preg_replace('/#CITY#/', '', $this->category->seo_h2);
        }

        parent::index($this->request);

        $jsonCategory = clone $this->category;
        unset($jsonCategory->seo_title);
        unset($jsonCategory->binding_filters);
        unset($jsonCategory->seo_description);
        unset($jsonCategory->top_description);
        unset($jsonCategory->description);
        unset($jsonCategory->napravlenie);
        unset($jsonCategory->logotype);
        unset($jsonCategory->longIcon);
        unset($jsonCategory->products);
        unset($jsonCategory->napravlenie_id);
        $city_url = '';
        if ($this->city) {
            $jsonCategory->url = $this->city->code;
            $city_url = $this->city->code.'/' ;
        }


        if (!$this->products_render->onFirstPage()) {
            unset($this->category->description);
        }

        $content = view('pages/catalog_parts', [
            'Category' => $this->category,
            'jsonCategory' => $jsonCategory,
            'Products' => $this->products_render,
            'is_no_add_url_category' => $is_no_add_url_category,

            'AllParameterFilter' => $this->all_parameter_filter,
            'filter' => new Filter(),
            'binding_filters' => $this->binding_filters,

            'city_url' => $city_url,
            'city_selected' => City::getSelectCityFromFromUI(),

            // json obj
            'categories_by_brand' => $this->categories_by_brand,
            'categories_by_type' => $this->filters_types,
            'categories_by_type_active' => $this->filters_types_active,
            'JsonAllParameterFilter' => json_encode($this->all_parameter_filter),
            'JsonActiveFilter' => json_encode($this->filters_active),
            'JsonExistentFilter' => json_encode($this->filters_url),
        ]);

        return response($content);
    }

    public function sale()
    {
        $arSale = [];

        $sharesProducts = Share::GetAllShares();

        if ($sharesProducts) {
            if (array_key_exists($this->url, $sharesProducts)) {
                $arSale['currentProduct'] = $this->url;
            }
        }


        $arSale['mark'] = $this->SaleMark();
        $arSale['category'] = $this->SaleCategory();

        if (isset($this->SaleAction()->product_action)) {
            $arSale['action'] = $this->SaleAction()->product_action;
        }

        if (isset($this->SaleType()->product_type)) {
            $arSale['action'] = $this->SaleType()->product_type;
        }

        foreach ($arSale as $key => $sale) {
            if (!$sale) {
                array_pull($arSale, $key);
            }
        }
        //return $arSale;
        if (count($arSale) > 0) {
            return true;
        } else {
            return false;
        }
    }


    protected function check_filter($url, $type_filter)
    {


        $filter_value = str_replace($type_filter . '-', '', $url);

        if (array_get($this->filters_url, $type_filter . '.' . $filter_value) == null) {
            $this::get404();
        } else {
            if ($type_filter == 'type') {
                $this->children_category = ChildCategorie::findCategoryByUrl($filter_value);
            }
            return $filter_value;
        }
    }
    protected function get404()
    {
        abort('404', 'Ошибка 404');
    }
}
