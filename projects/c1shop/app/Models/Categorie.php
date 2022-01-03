<?php

namespace App\Models;

use App\Http\Sections\parts;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Categorie
 *
 * @property int $id
 * @property string $name
 * @property string|null $logotype
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $url
 * @property string|null $longIcon
 * @property string|null $binding_filters
 * @property int|null $show_filters
 * @property int|null $show_in_nav
 * @property string $description
 * @property string|null $top_description
 * @property int|null $active
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $seo_key
 * @property int|null $napravlenie_id
 * @property string|null $seo_h1
 * @property string|null $seo_h2
 * @property string|null $seo_title_brand
 * @property string|null $seo_description_brand
 * @property string|null $img
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $additional_products
 * @property-read \App\Models\Brand $brands
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ChildCategorie[] $childCategory
 * @property-read \App\Models\Napravlenie|null $napravlenie
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read \App\Models\SeoFilter $seo_filter
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie fullCatalog()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie getBindingFilters($category)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie getSearchCategory()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie showInNav()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereBindingFilters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereLogotype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereLongIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereNapravlenieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereSeoDescriptionBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereSeoH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereSeoH2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereSeoKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereSeoTitleBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereShowFilters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereShowInNav($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereTopDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereUrl($value)
 * @mixin \Eloquent
 */
class Categorie extends Model
{
    protected $table = 'categories';
    //что разрешаем править
    protected $fillable = [
        'name', 'photos', 'child_category', 'logotype', 'longIcon', 'id'
    ];

    public function childCategory()
    {
        return $this->hasMany('App\Models\ChildCategorie', 'parent_category');
    }

    public function GetChildCategory(){
        return $this->hasMany('App\Models\ChildCategorie', 'parent_category')->get();
    }

    static function GetCategoryToUrl($url){
        return Categorie::where('url', $url)->first();
    }

    public function GetProducts(){
        return $this->hasMany('App\Models\Product', 'category')->get();
    }

    public function scopeShowInNav($query){
        return $query->where('show_in_nav', 1);
    }

    public function scopeGetSearchCategory($query){
        return $query->ShowInNav()->whereNotBetween('id', [10,11])->get();
    }

    public function scopeGetBindingFilters($query, $category) {
        return $query->where('id', $category)
            ->orWhere('url', $category)
            ->select('binding_filters')->first();
    }

    public function brands(){
        return $this->hasOne('App\Models\Brand', 'categories_id');
    }

    public function scopeFullCatalog($query) {
        return $query->where('id', 18)->first();
    }

    public function napravlenie(){
        return $this->belongsTo(Napravlenie::class);
    }

    public function products(){
        return $this->hasMany(Product::class, 'category');
    }

    public function parts(){
        return $this->hasMany(Part::class, 'category_id');
    }

    public function additional_products(){
        return $this->belongsToMany('App\Models\Product');
    }
    public function additional_parts(){
        return $this->belongsToMany(
            'App\Models\Part',
            'additional_part',
            'part_id',
            'additional_id'
        );
    }
    public function seo_filter(){
        return $this->hasOne(SeoFilter::class, 'category');
    }
}
