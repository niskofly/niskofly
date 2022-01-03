<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\City
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $seo_part
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int|null $is_fast
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City fast()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereIsFast($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereSeoPart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class City extends Model
{
    protected $table = 'cities';
    protected $guarded = [];

    public function scopeFast($query)
    {
        return $query->where('is_fast', 1)->published();
    }

    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }

    /**
     * @return \App\Models\City|bool|\Illuminate\Database\Eloquent\Model|null
     */
    static function getSelectCity()
    {
        if (array_key_exists('CITY_ID', $_COOKIE)) {
            return self::where('id', $_COOKIE['CITY_ID'])->published()->first();
        } else {
            return false;
        }
    }

    /**
     * @return \App\Models\City|bool|\Illuminate\Database\Eloquent\Model|null
     */
    static function getSelectCityFromFromUI()
    {
        if (array_key_exists('CITY_ID', $_COOKIE)) {
            return self::where('id', $_COOKIE['CITY_ID'])->published()->first();
        }
        return false;
//        else {
//            if (FundamentalSetting::GetSetting('default_city_id')) {
//                return self::where('id', FundamentalSetting::GetSetting('default_city_id')->value)->first();
//            } else {
//                return false;
//            }
//        }
    }

    static function getSelectCityUrl()
    {
        if (array_key_exists('CITY_ID', $_COOKIE)) {
            return self::where('id', $_COOKIE['CITY_ID'])->published()->first()->code;
        } else {
            if (FundamentalSetting::GetSetting('default_city_id')) {
                return self::where('id', FundamentalSetting::GetSetting('default_city_id')->value)->published()->first()->code;
            } else {
                return false;
            }
        }
    }
}