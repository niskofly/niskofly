<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contact
 *
 * @property int $id
 * @property string $address
 * @property string $phone_text
 * @property string|null $skype
 * @property string $coordinates
 * @property string $city
 * @property string|null $email
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $time
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact branches()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact headOffice()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereCoordinates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact wherePhoneText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereSkype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Contact extends Model
{
    protected $table = 'contacts';

    protected $fillable
        = [
            'address',
            'phone_text',
            'skype',
            'coordinates',
            'city',
            'email',
            'time',
            'transport_company',
            'published',
            'is_branch',
        ];

    public function scopeHeadOffice($query) {
        return $query->where('city', 'Череповец');
    }

    public function scopeBranches($query) {
        return $query->where('city', '!=', 'Череповец')->where('published', 1)->where('is_branch', 1);
    }

    public function scopePickpoints($query)
    {
        return $query->where('city', '!=', 'Череповец')->where('published', 1)->where('is_branch', 0);
    }
}
