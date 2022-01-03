<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ChildCategorie
 *
 * @property int $id
 * @property string $name
 * @property string $parent_category
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $url
 * @property int $active
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $seo_key
 * @property string|null $seo_h1
 * @property string|null $seo_h2
 * @property string|null $description
 * @property string|null $top_description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereParentCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereSeoH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereSeoH2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereSeoKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereTopDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereUrl($value)
 * @mixin \Eloquent
 */
class ChildCategorie extends Model
{
    protected $table = 'child_categories';

    protected $fillable = [
      'name', 'parent_category'
    ];

    public function parentCategory()
    {
        return $this->belongsTo('App\Models\Categorie', 'parent_category')->first();
    }

    static function findCategoryByUrl($url) {
        return ChildCategorie::whereUrl($url)->first();
    }

    /**
     * Связь для подкатегорий
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function category_parts() {
        return $this->belongsToMany('App\Models\Part', 'category_part', 'category_id' ,'part_id');
    }

    public function parts() {
        return $this->hasMany('App\Models\Part',  'category_id' );
    }
}
