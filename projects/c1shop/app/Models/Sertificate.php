<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Sertificate
 *
 * @property int $id
 * @property string $name
 * @property string $photo
 * @property int $active
 * @property int $sort
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sertificate active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sertificate sort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sertificate whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sertificate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sertificate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sertificate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sertificate wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sertificate whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sertificate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Sertificate extends Model
{
    protected $table = 'sertificates';

    protected $fillable = [
        'name',
        'sort',
        'active',
        'photo'
    ];

    public function scopeActive($query){
        return $query->where('active', 1);
    }

    public function scopeSort($query){
        return $query->orderBy('sort', 'desc');
    }
}
