<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Article
 *
 * @property int $id
 * @property string $name
 * @property string $preview_description
 * @property string $preview_image
 * @property string $full_content
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_key
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereFullContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article wherePreviewDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article wherePreviewImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereSeoKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereUpdatedAt($value)
 */
	class Article extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Categorie
 *
 * @property int $id
 * @property string $name
 * @property string $logotype
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $url
 * @property string $longIcon
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ChildCategorie[] $childCategory
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereLogotype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereLongIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Categorie whereUrl($value)
 */
	class Categorie extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ChildCategorie
 *
 * @property int $id
 * @property string $name
 * @property string $parent_category
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereParentCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChildCategorie whereUrl($value)
 */
	class ChildCategorie extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CompletedProject
 *
 * @property int $id
 * @property string $name
 * @property string $photos
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompletedProject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompletedProject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompletedProject whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompletedProject wherePhotos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompletedProject whereUpdatedAt($value)
 */
	class CompletedProject extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FundamentalSetting
 *
 * @property int $id
 * @property string $name Человеческое название настройки/параметра. Например "Email-ы для оповещений"
 * @property string $var параметр, на который завязаться в коде. Изменять его уже нельзя ибо пото искать все вхождения в код.
 * @property string $value Значение параметра (список почт, цифровое значение и тп.)
 * @property string $description Описание параметра для вывода в админке в качестве подказки
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FundamentalSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FundamentalSetting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FundamentalSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FundamentalSetting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FundamentalSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FundamentalSetting whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FundamentalSetting whereVar($value)
 */
	class FundamentalSetting extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 */
	class User extends \Eloquent {}
}

