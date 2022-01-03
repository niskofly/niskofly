<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Traits\OrderableModel;

/**
 * Class Brochure
 *
 * @package App\Models
 * @property int $id
 * @property string|null $name
 * @property int|null $active
 * @property string|null $file
 * @property string|null $img
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $type_id Тип документа
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brochure active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brochure booklets()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brochure prices()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brochure whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brochure whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brochure whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brochure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brochure whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brochure whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brochure whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brochure whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Brochure extends Model
{
    protected $table = 'brochures';

    protected $fillable = [
        'name',
        'active',
        'file',
        'img',
        'type_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    protected function type()
    {
        return $this->hasMany(BrochureType::class, 'id', 'type_id');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Relations\BelongsTo[]|null
     */
    public function getType($id)
    {
        return $this->type()->find($id);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1)->get();
    }

    /**
     * Рекламные проспекты.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeBooklets($query)
    {
        return $query->where('active', 1)->where('type_id', 1)->get();
    }

    /**
     * Прайс-листы.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopePrices($query)
    {
        return $query->where('active', 1)->where('type_id', 2)->get();
    }
}
