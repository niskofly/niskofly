<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Article
 *
 * @property int $id
 * @property string $name
 * @property string $preview_description
 * @property string $preview_image
 * @property string $full_content
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $seo_key
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $url
 * @property string $type
 * @property string $active
 * @property string|null $date_view
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article getContentByType($type, $notUrl)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article news()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article notNews()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereDateView($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereFullContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article wherePreviewDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article wherePreviewImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereSeoKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereUrl($value)
 * @mixin \Eloquent
 */
class Article extends Model
{
    protected $table = "articles";

    protected $fillable = [
        'name',
        'preview_description',
        'preview_image',
        'full_content',
        'seo_title',
        'seo_description',
        'seo_key',
        'active',
        'type'
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeNotNews($query)
    {
        return $query->where('type', '!=', 1);
    }

    public function scopeNews($query)
    {
        return $query->where('type', '=', 1)->orderBy('date_view', 'desc');
    }

    public function scopeGetContentByType($query, $type, $notUrl){
        return $query->Active()->where('type', '=', $type)->where('url', '!=', $notUrl);
    }


}
