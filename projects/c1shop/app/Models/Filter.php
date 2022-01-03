<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Filter
 *
 * @property int $id
 * @property string $name
 * @property int $active
 * @property string $type_filter
 * @property string|null $help
 * @property string $value
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $binding_category
 * @property string|null $custom_value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filter whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filter whereBindingCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filter whereCustomValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filter whereHelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filter whereTypeFilter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filter whereValue($value)
 * @mixin \Eloquent
 */
class Filter extends Model
{
    protected $table = 'filters';

    protected $fillable = [
        'name',
        'active',
        'type_filter',
        'help',
        'value',
        'binding_category'
    ];

    protected static function boot()
    {
        parent::boot();

        Filter::updating(function ($model_request) {
                $products = Product::FilterProduct([$model_request->type_filter => $model_request->value])->get();
                $model_request->value = $model_request->custom_value ? $model_request->custom_value :  str_slug($model_request->name);
                if(count($products) > 0){
                    foreach ($products as $product){
                        \Illuminate\Support\Facades\DB::table('products')
                            ->where('id', $product->id)
                            ->update([$model_request->type_filter => $model_request->value]);
                    }
                }

            return $model_request;
        });

        Filter::creating(function ($model_request) {
            $model_request->value = $model_request->custom_value ? $model_request->custom_value :  str_slug($model_request->name);
            return $model_request;
        });
    }

    /**
     * @param $value
     *
     * @return \Illuminate\Support\Collection
     */
    public function getBindingCategoriesByValue($value)
    {
        return $this->where('value', $value)->get();
    }

    static function GetTypeFilter($findType)
    {
        //dd($findType);
        $arGetFilters = [];
        foreach (Filter::where('type_filter', $findType)->get() as $item) {
            $arGetFilters[$item->value] = $item->name;
        }
        return $arGetFilters;
    }

    static function GetAllVariantFilter($id_category)
    {
        $bindingFilters = Categorie::GetBindingFilters($id_category);

        $bindingFilters = unserialize($bindingFilters->binding_filters) ? unserialize($bindingFilters->binding_filters) : [0=>'mark'];

        return Filter::where('active', 1)
            ->whereIn('type_filter', $bindingFilters)
            ->get()
            ->groupBy('type_filter')
            ->map(function ($items) {
                $arReturn = [];
                foreach ($items as $item) {
                    $arReturn[$item['value']] = $item;
                }
                return $arReturn;
            });
    }

    static function GetAllVariantByAction($action){

        $bindingFilters = Categorie::GetBindingFilters($action);
        $bindingFilters = unserialize($bindingFilters->binding_filters);


        return Filter::where('active', 1)
            ->whereIn('type_filter', $bindingFilters)
            ->get()
            ->groupBy('type_filter')
            ->map(function ($items) {
                $arReturn = [];
                foreach ($items as $item) {
                    $arReturn[$item['value']] = $item;
                }
                return $arReturn;
            });
    }

    static function GetAllVariantByInStock($category){
        $bindingFilters = Categorie::GetBindingFilters($category->id);
        $bindingFilters = unserialize($bindingFilters->binding_filters);

        return Filter::where('active', 1)
            ->whereIn('type_filter', $bindingFilters)
            ->get()
            ->groupBy('type_filter')
            ->map(function ($items) {
                $arReturn = [];
                foreach ($items as $item) {
                    $arReturn[$item['value']] = $item;
                }
                return $arReturn;
            });
    }

    static function getLinkBrandCategory($filterKey) {
        $arSyncList = [
            'vyazma-rossiya' => '6', // ключ фильтра => id связанного бренда
            'lavamac-belgiya' => '3',
            'krebe-sloveniya' => '4',
            'sidi-italiya' => '9',
            //'firbimatic-italiya' => '',
            'ipso-belgiya' => '11',
            'unimac-chekhiya' => '12'
        ];

        if(array_key_exists($filterKey, $arSyncList)) {
            $brandCategory = Brand::active()->find($arSyncList[$filterKey])->categories;
            if($brandCategory)
                return self::getGeoCatalogLink($brandCategory->url);
        }
    }


    static function getGeoCatalogLink($link) {
        $city = \App\Models\City::getSelectCity();
        $city_url = '';
        if($city) {
            $city_url = $city->code.'/';
        }

        return "/catalog/{$city_url}{$link}";
    }


}
