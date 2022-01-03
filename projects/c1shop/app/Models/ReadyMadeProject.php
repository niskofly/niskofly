<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ReadyMadeProject
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $params
 * @property int $type
 * @property int $active
 * @property int $sort
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadyMadeProject active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadyMadeProject filterImport()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadyMadeProject filterRus()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadyMadeProject getByID($id)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadyMadeProject sort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadyMadeProject whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadyMadeProject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadyMadeProject whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadyMadeProject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadyMadeProject whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadyMadeProject whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadyMadeProject whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadyMadeProject whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadyMadeProject whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReadyMadeProject extends Model
{
   protected $table = 'ready_made_projects';

   protected $fillable = [
       'name',
       'description',
       'params',
       'type',
       'sort'
   ];

   public function scopeFilterRus($query){
       return $query->where('type', 0);
   }

    public function scopeFilterImport($query){
        return $query->where('type', 1);
    }

    public function scopeActive($query){
        return $query->where('active', 1);
    }

    public function scopeSort($query){
        return $query->orderBy('sort', 'desc');
    }

    public function scopeGetByID($query, $id){
        return $query->Active()->where(['id' => $id])->first();
    }

}