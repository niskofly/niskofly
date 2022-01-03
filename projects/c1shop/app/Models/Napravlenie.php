<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Napravlenie
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $url
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property-read \App\Models\Categorie $categorie
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Napravlenie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Napravlenie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Napravlenie whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Napravlenie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Napravlenie whereUrl($value)
 * @mixin \Eloquent
 */
class Napravlenie extends Model
{
    /**
     * A user may have multiple roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function categorie()
    {
        return $this->hasOne(Categorie::class);
    }

    protected static function boot()
    {
        parent::boot();
        Napravlenie::updating(function ($model_request) {
            return $model_request->url = str_slug($model_request->name);
        });

        Napravlenie::creating(function ($model_request) {
            return $model_request->url = str_slug($model_request->name);
        });
    }

}
