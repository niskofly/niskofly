<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer
 *
 * @property int $id
 * @property int $active
 * @property string $name
 * @property string $coordinates
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $address
 * @property string $city
 * @property string|null $logo
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer groupCity()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereCoordinates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'name',
        'coordinates',
        'active',
        'address',
        'city'
    ];


    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeGroupCity($query)
    {
        return $query->get()->where('active', 1)->groupBy('city')->map(function ($item) { return $item; } )->toArray();
    }

}
