<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BrochureType
 *
 * @package App\Models
 * @property int $id ID
 * @property string $name Название
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BrochureType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BrochureType whereName($value)
 * @mixin \Eloquent
 */
class BrochureType extends Model
{
    protected $table = 'brochure_types';

    protected $fillable = [
        'name',
    ];

    /**
     * Get brochure type name.
     *
     * @param $id
     *
     * @return mixed
     */
    public function getName($id)
    {
        return ($this->find($id)->name);
    }
}
