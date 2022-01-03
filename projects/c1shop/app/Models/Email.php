<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Email
 *
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property string|null $type
 * @property string|null $theme
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $comment
 * @property int|null $id_product
 * @property string|null $id_product_list
 * @property string|null $id_part_list
 * @property int|null $id_finished_project
 * @property int|null $id_share
 * @property string|null $spare_part_list
 * @property string|null $calculate_kit_params
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereCalculateKitParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereIdFinishedProject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereIdProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereIdProductList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereIdShare($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereSparePartList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereTheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Email extends Model
{
    protected $table = "emails";

    protected $fillable = [

    ];


    static function GetTypeEmails()
    {
        $arType = [];
        foreach (Email::get() as $item) {
            $arType[$item->type] = $item->theme;
        }
        return $arType;
    }


    static function GetEmailInfoCalculateKit($params) {

        $params = unserialize($params);

        $info = '';

        foreach ($params as $name => $value){
            $info .= '<p>'.$name.' : '.$value.'</p>';
        }
        return $info;
    }


    static function GetEmailSparePartList($params) {

        $params = unserialize($params);

        $info = '';

        foreach ($params as $key => $spare){
            $spareInfo = <<< END_LIST
<p>
Название запчасти: {$spare['name']}<br>
-- Номер в каталоге: {$spare['number_catalog']}<br>
-- Комментарий: {$spare['comment']}<br>
</p>
--------------------------------------------------------------
END_LIST;

            $info .= $spareInfo;
        }
        return $info;
    }


    static function GetEmailFinishProject($id_project) {
        $project = ReadyMadeProject::GetByID($id_project);

        return '#'.$project->id.' - '.$project->name;
    }

    static function GetEmailSparePartList__Excel($params) {

        $params = unserialize($params);

        $info = '';


        foreach ($params as $key => $spare){

            $spareInfo = "Название запчасти: $spare[name] -- Номер в каталоге: $spare[number_catalog] -- Комментарий: $spare[comment]";
            $spareInfo .= "-----------------------------------------------";
            $info .= $spareInfo;
        }
        return $info;
    }

}
