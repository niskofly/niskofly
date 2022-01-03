<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SeoFilter
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $seo_h1
 * @property string|null $seo_h2
 * @property string|null $type
 * @property string|null $mark
 * @property int|null $active
 * @property int $category
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $series
 * @property string|null $loading
 * @property string|null $width_area
 * @property string|null $performance
 * @property string|null $solvent
 * @property-read \App\Models\Categorie $categories
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoFilter active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoFilter whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoFilter whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoFilter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoFilter whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoFilter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoFilter whereLoading($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoFilter whereMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoFilter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoFilter wherePerformance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoFilter whereSeoH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoFilter whereSeoH2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoFilter whereSeries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoFilter whereSolvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoFilter whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoFilter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoFilter whereWidthArea($value)
 * @mixin \Eloquent
 */
class SeoFilter extends Model
{
    protected $table='seo_filters';

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function categories()
    {
        return $this->belongsTo('App\Models\Categorie', 'category', 'id');
    }
}
