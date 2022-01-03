<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Traits\OrderableModel;

/**
 * App\Models\Brand
 *
 * @property int $id
 * @property int $active
 * @property string $name
 * @property string $photo
 * @property string $url
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $categories_id
 * @property string|null $filter_mark
 * @property string|null $default_img
 * @property int $order
 * @property-read \App\Models\Categorie|null $categories
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand findByPosition($position)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand orderModel()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereCategoriesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereDefaultImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereFilterMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereUrl($value)
 * @mixin \Eloquent
 */
class Brand extends Model
{
    use OrderableModel;

    protected $table = "brands";

    protected $fillable = [
        'name',
        'photo',
        'active',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1)->orderBy('order');
    }

    public function categories() {
        return $this->belongsTo(Categorie::class);
    }

    public function getOrderField()
    {
        return 'order';
    }

    /**
     * @param $url
     *
     * @return \App\Models\Brand|\Illuminate\Database\Eloquent\Model|null
     */
    public function getByUrl($url)
    {
        $url = explode('-', $url)[0];
        return $this::where('url', $url)->first();
    }
}

