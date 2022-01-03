<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Share
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string $active
 * @property string $preview_description
 * @property string $preview_image
 * @property string $full_content
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $seo_key
 * @property int|null $sort
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $product_mark
 * @property int|null $product_category
 * @property string|null $product_action
 * @property string|null $product_type
 * @property string|null $by_product
 * @property int $is_pinned
 * @property string|null $new_design_image
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share getContentByType($type, $notUrl)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share getShareToID($id)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereByProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereFullContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereIsPinned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereNewDesignImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share wherePreviewDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share wherePreviewImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereProductAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereProductCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereProductMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereSeoKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereUrl($value)
 * @mixin \Eloquent
 */
class Share extends Model
{
    protected $table = "shares";
    protected $fillable = [
        'by_product',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeGetContentByType($query, $type, $notUrl){
        return $query->Active()->where('type', '=', $type)->where('url', '!=', $notUrl);
    }

    static function GetAllShares(){
        $SharesProduct = [];
        foreach (Share::Active()->get() as $item) {
            if($item->by_product){
                $arUrlProducts = unserialize($item->by_product);

                foreach ($arUrlProducts as $urlProduct){
                    $SharesProduct[$urlProduct] = $item->id;
                }

            }
        }
        if(count($SharesProduct) > 0){
            return $SharesProduct;
        }

        return false;

    }

    public function scopeGetShareToID($query, $id){
        return $query->Active()->where(['id' => $id])->first();
    }

    static function getInfoEmails($id_share){
        if(!$id_share) {
            return false;
        }

        $share = Share::GetShareToID($id_share)->first();
        if($share){
            return "<a href='http://www.laundrypro.ru/share/$share->url' target='_blank'>$share->name</a>";
        } else {
            return "акция не найдена";
        }
    }


    static function getInfoExcel($id_share){
        if(!$id_share) {
            return false;
        }

        $share = Share::GetShareToID($id_share)->first();

        if($share){
            return $share->name;
        } else {
            return "акция не найдена";
        }

    }

}
