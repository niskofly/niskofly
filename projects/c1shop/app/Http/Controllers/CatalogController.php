<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\ChildCategorie;
use App\Models\City;
use App\Models\Filter;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class CatalogController extends MainController
{
    protected $request;
    protected $products__storage;
    protected $activeFilters = [];
    protected $category = false;
    protected $binding_filters = [];
    protected $children_category = false;

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
    public function switch_content(Request $request)
    {
        $this->request = $request;
        $category_url = Route::input('category');

        $type_filter = explode('-', $category_url);
        $is_set_filter = Filter::where([
            ['type_filter', '=', $type_filter[0]],
            ['value', '=', str_replace($type_filter[0] . '-', '', $category_url)]
        ])->first();

        if (!$category_url || $is_set_filter) {
            return $this->render__catalog();
        } else {
            $this->category = Categorie::where('url', $category_url)->first();

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
     * Переключение городов.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function switch_content_city(Request $request)
    {
        $this->request = $request;
        $category_url = Route::input('category');

        $this->city = City::getSelectCity();
        $request_city = City::where('code', Route::input('city'))->published()->first();

        // Если нет города в запросе, но выбран город
        if ((is_null($request_city) && $this->city)) {
            Route::current()->setParameter('type', Route::current()->parameter('category'));
            Route::current()->setParameter('category', Route::current()->parameter('city'));
            Route::current()->setParameter('city', $this->city->code);
            return redirect()->route('catalog', Route::current()->parameters);
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
                return redirect()->route('catalog', Route::current()->parameters);
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
            $this->category = Categorie::where('url', $category_url)->first();

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
     * Рендер Направление деятельности.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function render_napravlenie()
    {
        $productsAll = $this->category->napravlenie->products;

        $this->binding_filters = unserialize($this->category->binding_filters) ? unserialize($this->category->binding_filters) : [];
        $this->filters_url = $this->get_filters_by_products($productsAll, false);
        $this->filters_render = $this->get_filters_by_render($productsAll);
        $this->filters_active = $this->get_selected_filters();
        $this->filters_url = $this->get_filters_by_products($productsAll, true);
        $this->products_render = $this->category->napravlenie->products()->where($this->filters_active)->active()->paginate(16);

        if (count($this->request->route()->parameters) > 1 && count($this->filters_active) == 0 && !$this->city || count($this->request->route()->parameters) > 2 && count($this->filters_active) == 0 && $this->city) {
            return $this->render_product();
        }
        return $this->render();
    }

    /**
     * Рендер брендов.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function render__brand()
    {
        $productsAll = Product::where('mark', $this->category->brands->filter_mark)->active()->get();
        $this->category->show_filters = 0;
        $this->binding_filters = unserialize($this->category->binding_filters) ? unserialize($this->category->binding_filters) : [];
        $this->categories_by_brand = $this->get_filter_of_categories($productsAll);
        $this->products_render = Product::where('mark', $this->category->brands->filter_mark)->active()->where($this->filters_active)->active()->paginate(16);
        return $this->render();
    }

    /**
     * Рендер каталога.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function render__catalog()
    {
        $this->category = Categorie::where('url', 'katalog-produktsii')->first();

        $productsAll = Product::active()->get();


        $this->binding_filters = unserialize($this->category->binding_filters) ? unserialize($this->category->binding_filters) : [];
        $this->filters_url = $this->get_filters_by_products($productsAll, false);
        $this->filters_render = $this->get_filters_by_render($productsAll);

        $this->filters_active = $this->get_selected_filters();
        $this->filters_url = $this->get_filters_by_products($productsAll, true);

        $this->products_render = Product::active()->where($this->filters_active)->active()->paginate(16);

        return $this->render(true);

    }

    /**
     * Рендер категории.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function render__category()
    {

        $products_category = $this->category->products;

        $products_additional_category = $this->category->additional_products;

        $productsAll = $this->get_collapsed_collecton([$products_category, $products_additional_category]);

        $this->binding_filters = unserialize($this->category->binding_filters) ? unserialize($this->category->binding_filters) : [0 => 'mark'];
        $this->filters_url = $this->get_filters_by_products($productsAll, false);
        $this->filters_render = $this->get_filters_by_render($productsAll);

        $this->filters_active = $this->get_selected_filters();
        //dd($this->filters_active  );
        $this->filters_url = $this->get_filters_by_products($productsAll, true);

        if (count($this->request->route()->parameters) > 1 && count($this->filters_active) == 0 && !$this->city || count($this->request->route()->parameters) > 2 && count($this->filters_active) == 0 && $this->city) {
            return $this->render_product();
        }

        $products_category__filtered = $this->category->products()->where($this->filters_active)->get();
        $products_additional__filtered = $this->category->additional_products()->where($this->filters_active)->get();

        $products_filtered = $this->get_collapsed_collecton([$products_category__filtered, $products_additional__filtered]);

        $products_ids = [];
        foreach ($products_filtered as $product) {
            $products_ids[$product->id] = $product->id;
        }

        $this->products_render = Product::whereIn('id', $products_ids)->where($this->filters_active)->active()->paginate(16);

        return $this->render();
    }

    /**
     * Рендер "Оборудование на складе"
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    protected function render_in_stock()
    {
        $productsAll = Product::active()->GetInStocks();

        $this->binding_filters = unserialize($this->category->binding_filters) ? unserialize($this->category->binding_filters) : [];
        $this->filters_url = $this->get_filters_by_products($productsAll, false);
        $this->filters_render = $this->get_filters_by_render($productsAll);

        $this->filters_active = $this->get_selected_filters();

        //$this->filters_active = array_add($this->filters_active, 'in_stock', 1);

        $this->filters_url = $this->get_filters_by_products($productsAll, true);

        // Выборка типов оборудования для кастомного фильтра
        if (!$productsAll->isEmpty()) {
            $this->filters_types = $this->get_product_types($productsAll);
        }
        // Выборка типов из запроса
        $this->filters_types_active = array_filter(explode(',', $this->request->query('type')));
        unset($this->filters_render['performance']);
        //$this->products_render = Product::active()->where($this->filters_active)->active()->paginate(16);

        $categories = collect();
        foreach ($this->filters_types_active as $t) {
            $cat = Categorie::whereUrl($t)->first();
            if ($cat !== null) {
                $categories->push($cat->id);
            }
        }

        $productsQuery = Product::active()
            ->where('in_stock', 1)
            ->where(function ($q) use ($categories) {
                if (!empty(array_filter($this->filters_types_active))) {
                    $q->whereIn('category', $categories);
                }
            })
            ->where($this->filters_active)
            ->active();

        /**
         * Добавление в выборку товаров ограничений стандартного фильтра
         */
        if($additional_filters = $this->get_selected_filters()) {
            $productsQuery = $productsQuery->where($additional_filters);
        }

        $this->products_render = $productsQuery->paginate(16);

        return $this->render();
    }

    /**
     * Возвращает список типов оборудования (дочерние категории).
     *
     * @param \Illuminate\Support\Collection $products
     *
     * @return \Illuminate\Support\Collection
     */
    protected function get_product_types(Collection $products) {
        $types = collect();
        $filtered_categories = collect();
        foreach ($products as $product) {
            $types->push($product->category);
            $filtered_categories = $types->filter(function($value, $key) {
                return (!empty($value) || !is_null($value));
            })->unique();
        }
        $categories = collect();
        foreach ($filtered_categories as $fc) {
            $categories->push(Categorie::whereId($fc)->first());
        }
        return $categories;
    }

    /**
     * Рендер товара.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function render_product()
    {
        $product_url = $this->city ? $this->request->route()->parameters['type1'] : $this->request->route()->parameters['category'];
        $product = Product::GetProduct($product_url, $this->category->id);

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

            if (isset($product->loading_view)) {
                $productDescription .= ' с загрузкой ' . $product->loading_view . ' кг';
            }

            if (isset($product->mark)) {
                $mark = explode(' ', $product->filterMark()->name);
                $productDescription .= ' от производителя «' . $mark[0] . '»';
            }

            if (isset($product->width_area_view)) {
                $productDescription .= ' с шириной вала ' . $product->width_area_view . ' мм';
            }

            $Performance = $product->getValueParams($product->params, 'Производительность, кг/час');
            $ShaftDiameter = $product->getValueParams($product->params, 'Диаметр вала, мм');
            $typeHeating = $product->getValueParams($product->params, 'Вид обогрева');


            if ($Performance) {
                $productDescription .= ' вид обогрева ' . $Performance . ' кг/ч';
            }

            if ($ShaftDiameter) {
                $productDescription .= ' диаметр вала ' . $ShaftDiameter . ' мм';
            }

            if ($typeHeating) {
                $productDescription .= ' вид обогрева ' . $typeHeating;
            }

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

        //dd($product->type);

        $stiralka = Product::getRandStiralka();
        $cushilka = Product::getRandCushilka();
        $gladilka = Product::getRandGladilka();

        if (count($product) > 0) {
            return view('pages.product.index', [
                'Category' => $this->category,
                'ChildCategory' => ChildCategorie::findCategoryByUrl($product->type),
                'Product' => $product,
                'stiralka' => $stiralka,
                'cushilka' => $cushilka,
                'gladilka' => $gladilka,

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
                    case 'loading':
                        $loading = array_get($this->filters_render, 'loading.' . $filter);
                        $filter_str_parameter .= ' с загрузкой ' . $loading->name . ' кг';
                        break;
                    case 'width_area':
                        $filter_str_parameter .= ' шириной зоны глажения ' . $filter . ' мм';
                        break;
                    case 'performance':
                        $filter_str_parameter .= ' производительностью ' . $filter . ' кг/ч';
                        break;
                    case 'revers':
                        if ($filter == 'est') {
                            $filter_str_parameter .= ' с реверсом барабана ';
                        } else {
                            $filter_str_parameter .= ' без реверса барабана';
                        }
                        break;
                    case 'solvent':
                        if ($filter === 'alternative') {
                            $filter_str_parameter .= ' на альтернативном растворителе';
                        } elseif ($filter === 'perchloroethylene') {
                            $filter_str_parameter .= ' на перхлорэтилене ';
                        } else {
                            $solvent = array_get($this->filters_render, 'solvent.' . $filter);
                            $filter_str_parameter .= ' на растворителе ' . $solvent->name;
                        }
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

        $seo_filter = $this->category->seo_filter()->active()->where($seo_article_parameter)->first();

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
            $jsonCategory->url = $this->city->code . '/' . $jsonCategory->url;
            $city_url = $this->city->code . '/';
        }


        if (!$this->products_render->onFirstPage()) {
            unset($this->category->description);
        }

        $content = view('pages/catalog', [
            'Category' => $this->category,
            'jsonCategory' => $jsonCategory,
            'Products' => $this->products_render,
            'is_no_add_url_category' => $is_no_add_url_category,

            'AllParameterFilter' => $this->filters_url,
            'filter' => new Filter(),
            'binding_filters' => $this->binding_filters,

            'city_url' => $city_url,
            'city_selected' => City::getSelectCityFromFromUI(),

            // json obj
            'categories_by_brand' => $this->categories_by_brand,
            'categories_by_type' => $this->filters_types,
            'categories_by_type_active' => $this->filters_types_active,
            'JsonAllParameterFilter' => json_encode($this->filters_render),
            'JsonActiveFilter' => json_encode($this->filters_active),
            'JsonExistentFilter' => json_encode($this->filters_url),
        ]);
        return response($content);
    }

    /**
     * @param $products
     * @return array
     */
    protected function get_filter_of_categories($products)
    {
        $filters = [];

        foreach ($products as $product) {
            $category = $product->category();

            unset($category->seo_title);
            unset($category->binding_filters);
            unset($category->seo_description);
            unset($category->description);
            unset($category->napravlenie);
            unset($category->logotype);
            unset($category->longIcon);
            unset($category->products);
            unset($category->napravlenie_id);

            $filters[$category->url] = $category;
        }

        return $filters;
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
            $info_filters = Filter::GetAllVariantFilter($this->category->id);

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

            // фильтр величина загрузки
            if (starts_with($filter, 'loading-')) {
                $filters['loading'] = $this->check_filter($filter, 'loading');
            }

            // фильтр серия оборудования
            if (starts_with($filter, 'series-')) {
                $filters['series'] = $this->check_filter($filter, 'series');
            }

            // фильтр ширина зоны глажения
            if (starts_with($filter, 'width_area-')) {
                $filters['width_area'] = $this->check_filter($filter, 'width_area');
            }

            // фильтр реверс барабана
            if (starts_with($filter, 'revers-')) {
                $filters['revers'] = $this->check_filter($filter, 'revers');
            }

            // фильтр направление деятельности
            if (starts_with($filter, 'performance-')) {
                $filters['performance'] = $this->check_filter($filter, 'performance');
            }

//            // фильтр направление деятельности
            if (starts_with($filter, 'action-')) {
                $filters['action'] = $this->check_filter($filter, 'action');
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
            if (starts_with($filter, 'solvent-')) {
                $filters['solvent'] = $this->check_filter($filter, 'solvent');
            }
        }

        if (count($route_parameter) != count($filters) && !$this->category) {
            $this::get404();
        }
        return $filters;
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


    public function set_filter(Request $request)
    {
        $action = $request->get('action') === 'add';
        $category = $request->get('category');
        //$category_id = $request->get('id');

        $url = parse_url($request->get('url'), PHP_URL_QUERY);
        parse_str($url, $queries);

        $active_types = collect((isset($queries['type'])) ? explode(',', $queries['type']) : null);

        if ($action) {
            $filtered = $active_types;
            $filtered->push($category);
        } else {
            $filtered = $active_types->reject(function ($value, $key) use ($category) {
                return $value === $category;
            });
        }
        $filtered->all();

        return json_encode($filtered);
    }

    public function renderAjaxCatalog(Request $request)
    {
        $this->request = $request;
        return $this->render__catalog(); //View::make('pages.catalog');
    }
}
