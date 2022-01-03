<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Review
 *
 * @property int $id
 * @property string $author
 * @property string $company
 * @property string $curt_text
 * @property string $file
 * @property int $published
 * @property int $order
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review activeSort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereCurtText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Review extends Model
{
    // SCOPED
    public function scopeActiveSort($query)
    {
        return $query->where('published', 1)->orderBy('order');
    }
    // END SCOPED
}
