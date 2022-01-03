<?php

namespace App\Models;

use App\Helper;
use App\Http\Sections\brands;
use GuzzleHttp\Psr7\str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Part extends Model
{
    protected $table = 'parts';

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

    public function scopeGetPart($query, $url, $category_id)
    {

        return $query->Active()->where(['url' => $url, 'category_id' => $category_id])->first();
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1)->orderBy('sort', 'asc');
    }

    public function additional_parts(){
        return $this->belongsToMany(
            'App\Models\Part',
            'additional_part',
            'part_id',
            'additional_id'
        );
    }

    public function part_product(){
        return $this->belongsToMany(
            'App\Models\Product',
            'part_product',
            'part_id',
            'product_id'

        );
    }

    public function part_mark(){
        return $this->belongsToMany(
            Filter::class,
            'part_mark',
            'part_id',
            'mark_id'
        );
    }


    public function categoryUrl() {
        return ChildCategorie::select()->where(['type' => $this->type])->first();
    }
    /**
     * Связь для подкатегорий
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function category_parts() {
        return $this->belongsToMany('App\Models\ChildCategorie', 'category_part', 'part_id','category_id');
    }

    public function filterMark()
    {
        return $this->belongsTo('App\Models\Filter', 'mark', 'value')->first();
    }

    public function category() {
        return $this->hasOne(ChildCategorie::class, 'id','category_id');
    }

    public function scopeGetPartsByIDs($query, $ids)
    {
        return $query->Active()->whereIn('id', $ids)->get();
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


    public function scopeGetPartToID($query, $id)
    {
        return $query->Active()->where(['id' => $id])->first();
    }
    /**
     * @param $id
     *
     * @return \App\Models\Part|\App\Models\Part[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getById($id)
    {
        return $this->find($id);
    }

    public function getLatestParts(){
        if (isset($_COOKIE["js-list-parts-watched"])){
            $list_parts_watched = explode('-', $_COOKIE["js-list-parts-watched"]);
            return Part::GetPartsByIDs($list_parts_watched);
        }else{
            return collect([]);
        }
    }

    public function getValueParams($params, $key)
    {

        $arParams = unserialize($params);
        if (Part::array_depth($arParams) != 4 ) {

            if (count($arParams) > 0) {
                foreach ($arParams as $params) {
                    $arParamsKey[$params["name"]] = $params["value"];
                }
                if (array_key_exists($key, $arParamsKey)) {
                    return $arParamsKey[$key];
                }
            }

        }else{
            foreach ($arParams as $category){
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
        return false;
    }

}
