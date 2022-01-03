<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FundamentalSetting
 *
 * @property int $id
 * @property string $name Человеческое название настройки/параметра. Например "Email-ы для оповещений"
 * @property string $var параметр, на который завязаться в коде. Изменять его уже нельзя ибо пото искать все вхождения в код.
 * @property string $value Значение параметра (список почт, цифровое значение и тп.)
 * @property string|null $description Описание параметра для вывода в админке в качестве подказки
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FundamentalSetting getSetting($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FundamentalSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FundamentalSetting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FundamentalSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FundamentalSetting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FundamentalSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FundamentalSetting whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FundamentalSetting whereVar($value)
 * @mixin \Eloquent
 */
class FundamentalSetting extends Model
{
    protected $table = 'fundamental_settings';
    //что разрешаем править
    protected $fillable = [
        'name', 'var', 'value', 'description',
    ];

    public function scopeGetSetting($query, $code){
        return $query->where('var' , $code )->first();
    }
}
