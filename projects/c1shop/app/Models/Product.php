<?php

namespace App\Models;

use App\Helper;
use App\Http\Sections\brands;
use GuzzleHttp\Psr7\str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

/**
 * Class Product
 *
 * @package App\Models
 */
class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'url',
        'category',
        'mark',
        'type',
        'active',
        'actual_price',
        'old_price',
        'loading',
        'width_area',
        'performance',
        'revers',
        'below_type',
        'photo',
        'series',
        'solvent',
        'description',
        'params',
        'in_stock',
        'seo_key',
        'seo_title',
        'seo_description',
        'default_img',

        'load_file',
        'file_guide',
        'file_price_list',
        'file_kit_mounting',
        'file_kit_service',
        'file_kit_repair',
    ];

    protected $in_stock = array(
        0 => 'Под заказ',
        1 => 'На складе',
        2 => 'Товар в наличии и готов к отправке',
    );

    protected $file_columns = [
        'load_file' => 'Рекламный проспект',
        'file_guide' => 'Руководство по эксплуатации',
        'file_price_list' => 'Прайс лист',
        'file_kit_mounting' => 'Комплект - Монтажный',
        'file_kit_service' => 'Комплект - Сервисный',
        'file_kit_repair' => 'Комплект - Ремонтный',
        'scheme' => 'Чертеж',
    ];
    protected $file_columns_translit;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);

        $this->file_columns_translit = [
            'load_file' => Helper::translit('Рекламный проспект'),
            'file_guide' => Helper::translit('Руководство по эксплуатации'),
            'file_price_list' => Helper::translit('Прайс лист'),
            'file_kit_mounting' => Helper::translit('Комплект - Монтажный'),
            'file_kit_service' => Helper::translit('Комплект - Сервисный'),
            'file_kit_repair' => Helper::translit('Комплект - Ремонтный'),
        ];

    }

    static function getRandStiralka() {
        return Product::where('category', 1)->inRandomOrder()->first();
    }

    static function getRandCushilka() {
        return Product::where('category', 2)->inRandomOrder()->first();
    }

    static function getRandGladilka() {
        return Product::where('category', 3)->inRandomOrder()->first();
    }
   

    public function scopeGetProduct($query, $url, $id_category)
    {
        return $query->Active()->where(['url' => $url, 'category' => $id_category])->first();
    }

    public function scopeSortBy($query, $sort, $type)
    {
        if ($type) {
            return $query::sortByDesc($sort);
        } else {
            return $query::sortBy($sort);
        }
    }

    public function scopeGetProductToID($query, $id)
    {
        return $query->Active()->where(['id' => $id])->first();
    }

    public function scopeGetAllToIdCategory($query, $id)
    {
        return $query->Active()->where('category', $id)->get()->sortByDesc('sort');
    }

    public function scopeGetAllToAction($query, $type_action)
    {
        return $query->Active()->where('action', $type_action)->get()->sortByDesc('sort');
    }

    public function scopeGetInStocks($query)
    {
        return $query->where('in_stock', 1)->get();
    }

    public function scopeFilterProduct($query, $filters)
    {
        return $query->Active()->where($filters);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1)->orderBy('sort', 'asc');
    }

    public function scopeGetProductsByIDs($query, $ids)
    {
        return $query->Active()->whereIn('id', $ids)->get();
    }


    public function filterMark()
    {
        return $this->belongsTo('App\Models\Filter', 'mark', 'value')->first();
    }


    public function categories()
    {
        return $this->belongsTo('App\Models\Categorie', 'category', 'id');
    }

    public function scopeSearchProduct($query, $q, $category)
    {
        if (isset($category->id) && $q != '') {

            return $this->where('category', $category->id)->whereRaw(
                "MATCH(name, description) AGAINST(? IN BOOLEAN MODE)",
                array($q)
            )->get()->sortByDesc('sort');

        }
        if (isset($category->id)) {

            return $query->Active()->where('category', $category->id)->get()->sortByDesc('sort');

        } else {

            return $this->whereRaw(
                "MATCH(name, description) AGAINST(? IN BOOLEAN MODE)",
                array($q)
            )->get()->sortByDesc('sort');

        }
    }

    public function scopeLikeSearchProduct($query, $q, $category)
    {
        if (isset($category->id) && $q != '') {

            $products = $this->where('category', $category->id)
                ->where(function ($query) use ($q) {
                    $query->orWhere('name', 'like', '%' . $q . '%')
                        ->orWhere('description', 'like', '%' . $q . '%')
                        ->orWhere('params', 'like', '%' . $q . '%');
                })->get();
            $products->filter(function ($product, $key) use ($category) {

                $category_all = collect([intval($product->category)]);
                $additional_category = $product->additional_category;
                if (!$additional_category->isEmpty()) {
                    foreach ($additional_category as $category) {
                        $category_all->push($category->id);
                    }
                }
                if ($category_all->search($category->id)) {
                    return true;
                }
                return false;
            });

            return $products;
        }
        if (isset($category->id)) {

            return $query->Active()->where('category', $category->id)->get()->sortByDesc('sort');

        } else {

            return $this->where('name', 'like', '%' . $q . '%')
                ->orWhere('description', 'like', '%' . $q . '%')
                ->orWhere('params', 'like', '%' . $q . '%')
                ->get();

        }
    }

    public function scopeGetByBrands($query, $mark)
    {
        return $query->Active()->where('mark', $mark)->get();
    }

    public function SaleMark()
    {
        return $this->belongsTo('App\Models\Share', 'mark', 'product_mark')->where('active', 1)->first();
    }

    public function SaleCategory()
    {
        return $this->belongsTo('App\Models\Share', 'category', 'product_category')->where('active', 1)->first();
    }

    public function SaleAction()
    {
        return $this->belongsTo('App\Models\Share', 'action', 'product_action')->where('active', 1)->first();
    }

    public function SaleType()
    {
        return $this->belongsTo('App\Models\Share', 'type', 'product_type')->where('active', 1)->first();
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

    public static function array_depth(array $array) {
        $max_depth = 1;

        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = Product::array_depth($value) + 1;

                if ($depth > $max_depth) {
                    $max_depth = $depth;
                }
            }
        }

        return $max_depth;
    }
    public function getValueParams($params, $key)
    {
        if ( unserialize($params)) {
            $arParams = unserialize($params);
            if (Product::array_depth($arParams) != 4) {

                if (count($arParams) > 0) {
                    foreach ($arParams as $params) {
                        $arParamsKey[$params["name"]] = $params["value"];
                    }
                    if (array_key_exists($key, $arParamsKey)) {
                        return $arParamsKey[$key];
                    }
                }

            } else {
                foreach ($arParams as $category) {
                    if (count($category['items']) > 0) {
                        foreach ($category['items'] as $params) {
                            $arParamsKey[$params["name"]] = $params["value"];
                        }
                        if (array_key_exists($key, $arParamsKey)) {
                            return $arParamsKey[$key];
                        }
                    }
                }
            }
        }
        return false;
    }

    static function GetAllProducts()
    {
        $arGetProducts = [];
        foreach (Product::Active()->get() as $item) {
            $arGetProducts[$item->url] = $item->name;
        }
        return $arGetProducts;
    }

    static function getInfoEmails($id_products)
    {

        if (!$id_products) {
            return false;
        }
        $PRODUCTS = '';
        $products = [];
        if (is_int($id_products)) {
            $product = Product::GetProductToID($id_products);
            if (!!$product->first()) {
                $products[] = $product;
            }
            foreach ($products as $product) {
                $LIST_PRODUCTS = <<< END_LIST
    <a href="http://www.laundrypro.ru/catalog/{$product->category()->url}/{$product->url}" target="_blank">{$product->name}
    <b style="color: #333 !important">(1) </b></a>
END_LIST;
                $PRODUCTS .= $LIST_PRODUCTS;
            }

        } else {
            $arr_id_products = unserialize($id_products);
            $count_products = [];

            foreach ($arr_id_products as $key => $value){
                $cont = array_key_exists($value, $count_products) ?  $count_products[$value] : 0;
                $count_products[$value] = ++$cont;
            }
            $products = Product::GetProductsByIDs(unserialize($id_products));
            foreach ($products as $product) {
                $count = '';
                $LIST_PRODUCTS = <<< END_LIST
    <a href="http://www.laundrypro.ru/catalog/{$product->category()->url}/{$product->url}" target="_blank">{$product->name} 
        <b style="color: #333 !important">({$count_products[$product->id]}) </b>
    </a>
END_LIST;
                $PRODUCTS .= $LIST_PRODUCTS;
            }
        }


        return $PRODUCTS;
    }

    static function getInfoExcel($id_products)
    {

        if (!$id_products) {
            return false;
        }
        $PRODUCTS = '';

        $products = [];
        if (is_int($id_products)) {
            $product = Product::GetProductToID($id_products);
            if (!!$product->first()) {
                $products[] = $product;
                foreach ($products as $product) {
                    $LIST_PRODUCTS = $product->name . ' (1) || ';

                    $PRODUCTS .= $LIST_PRODUCTS;
                }
            }
        } else {
            $products = Product::GetProductsByIDs(unserialize($id_products));
            $arr_id_products = unserialize($id_products);
            $count_products = [];
            foreach ($arr_id_products as $key => $value){
                $cont = array_key_exists($value, $count_products) ?  $count_products[$value] : 0;
                $count_products[$value] = ++$cont;
            }
            foreach ($products as $product) {
                $LIST_PRODUCTS = $product->name . ' ('.$count_products[$product->id].') || ';

                $PRODUCTS .= $LIST_PRODUCTS;
            }
        }


        return $PRODUCTS;
    }

    public function napravlenie()
    {
        return $this->belongsToMany('App\Models\Napravlenie', 'napravlenie_product', 'product_id', 'napravlenie_id');
    }

    public function additional_category()
    {
        return $this->belongsToMany('App\Models\Categorie', 'categorie_product', 'product_id', 'categorie_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Categorie', 'category', 'id')->first();
    }

    /**
     * Фильтрация товаров для YML-экспорта.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeFilterToYml($query)
    {
        return $query->active()->where('actual_price', '>', 0)->where('block_to_yml', 0);
    }

    /**
     * Фильтрация товаров для YML-экспорта некоторых категорий.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeFilterToYmlForCategoriesSeveral($query)
    {
        return $query->active()->where('actual_price', '>', 0)->wherein('category',[1,2,3])->where('block_to_yml', 0);
    }

    /**
     * Фильтрация товаров для Турбо-страниц.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeFilterTurboToYml($query)
    {
        return $query->active()->where('actual_price', '>', 0);
    }

    /**
     * Возвращает доступных товаров (по серии и категории).
     *
     * @param $product
     * @param bool $exclude Исключать товар из выборки
     *
     * @return \App\Models\Product[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getAvailableOptions($product, $exclude = true)
    {
        if (is_null($product->series)) return collect();

        $items = $this::where('series', '=', $product->series)->where('category', '=', $product->category)->get()->sortBy('loading');
        return (!$exclude) ? $items : $items->filter(function ($value, $key) use ($product) {
            return $value->id !== $product->id;
        });

    }

    /**
     * Складской статус.
     *
     * @param $stock_id
     *
     * @return mixed
     */
    public function getInStockMessage($stock_id)
    {
        return (!is_null($stock_id)) ? $this->in_stock[$stock_id] : null;
    }

    /**
     * Получение товара по имени загруженного файла.
     *
     * @param $file
     *
     * @return bool|\Illuminate\Support\Collection
     */
    protected function getProductViaFile($file)
    {
        $product = collect();
        foreach ($this->file_columns as $column => $label) {
            $query = self::where($column, '=', $file)->get();
            if ($query->isNotEmpty()) {
                $extension = explode('.', $file)[1];
                $product->put('file', $file)->put('ext', $extension)->put('column', $column)->put('product', $query);
                break;
            }
        }
        return ($product->isNotEmpty()) ? $product : false;
    }

    /**
     * Загрузка файла.
     *
     * @param $file
     *
     * @return bool|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadFile($file)
    {
        $file_name = $this->getFileUrl($file);
        if ($file_name) {
            return response()->download($file, $file_name);
        }
        return false;
    }

    /**
     * Формирование имени файла.
     *
     * @param $file
     *
     * @return bool|string
     */
    public function getFileUrl($file)
    {
        $props = $this->getProductViaFile($file);
        if ($props) {
            $name = $props->get('product')->first()->url;
            $type = $this->file_columns_translit[$props->get('column')];
            $ext = $props->get('ext');
            return "{$type}---{$name}.{$ext}";
        }
        return false;
    }

    /**
     * Парсинг имени и поиск файла.
     *
     * @param $file_name
     *
     * @return mixed
     */
    public function parseFilename($file_name)
    {
        $file_name = str_replace('files/', '', $file_name);
        $file_name_array = explode('.', $file_name);
        $parsed = explode('---', $file_name_array[0]);
        $type_code = $parsed[0];
        $product_code = $parsed[1];
        $type = array_search($type_code, $this->file_columns_translit);
        return $this::where('url', '=', $product_code)->get()->first()->$type;
    }

    /**
     * @param $id
     *
     * @return \App\Models\Product|\App\Models\Product[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getById($id)
    {
        return $this->find($id);
    }

    /**
     * Связь для сопутствующих товаров.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function similar() {
        return $this->belongsToMany(Product::class, 'product_similar', 'product_id', 'similar_id');
    }

    /**
     * Выборка сопутствующих товаров.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]
     */
    public function getSimilar()
    {
        return $this->similar()->get();
    }

    /**
     * Удаление загруженных файлов при удалении товара.
     *
     * @param $id
     */
    public function removeFilesOnDelete($id)
    {
        $model = $this->getById($id);

        // Удаление файлов документов
        $files_fields = collect($this->file_columns)->keys();
        foreach ($files_fields as $field) {
            if (!empty($model->$field)) {
                File::delete($model->$field);
            }
        }
        // Удаление фото товара
        File::delete($model->photo);
    }

    public function getLatestProducts(){
        if (isset($_COOKIE["js-list-products-watched"])){
            $list_products_watched = explode('-', $_COOKIE["js-list-products-watched"]);
            return Product::GetProductsByIDs($list_products_watched);
        }else{
            return collect([]);
        }
    }
}
