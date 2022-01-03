<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CompletedProject
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $photos
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompletedProject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompletedProject whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompletedProject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompletedProject whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompletedProject wherePhotos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompletedProject whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CompletedProject extends Model
{
    protected $table = 'completed_projects';
    //что разрешаем править
    protected $fillable = [
        'name', 'photos',
    ];
}
