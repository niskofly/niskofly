<?php
/**
 * Created by PhpStorm.
 * User: borz
 * Date: 06/09/2019
 * Time: 11:17
 */

namespace app\components\roistat;
use DrillCoder\AmoCRM_Wrap\AmoCRM;
use DrillCoder\AmoCRM_Wrap\AmoWrapException;
use yii\base\Widget;

class RoistatPayFortWidget extends Widget
{
    const CRM_DOMINE    = 'headin';
    const CRM_LOGIN     = 'maxim@headin.pro';
    const CRM_KEY       = '63ffe45c7af651281990ad69d026bd2e392fad8c';

    public $data;
    public $email;
    public $price;
    public $id;

    public function init()
    {
        parent::init();
        if(empty($this->email)) {
            return false;
        }
        if(empty($this->id)) {
            return false;
        }
    }

    public function run()
    {
        try {
            $amo = new AmoCRM(self::CRM_DOMINE, self::CRM_LOGIN, self::CRM_KEY);
            //Поиск в СРМ
            $leads = $amo->searchLeads($this->email);
            if(empty($leads)) return false;

            $closedStatuses = array(142, 143);
            $leadsArr = [];
            foreach ($leads as $lead) {
                if ( !in_array($lead->getStatusId(), $closedStatuses)  && $lead->getCustomFieldValueInStr('486297') == $this->id) {
                    $leadsArr[] = $lead;
                }
            }
            $lead = null;
            if(count($leadsArr) > 0) {
                $lead = $leadsArr[0];

            //Убрать
            //self::writeToLog($lead, '', 'lead');
            //Убрать

            $lead->setStatus(142);
            $price = (int) ($this->price / 100);

            $lead->setSale($price);

            //$lead->setCustomFieldValue(487393, 952181);

            $lead->setCustomFieldValue(487393, 'HI On-Line RAK');
            return $lead->save();
            }else {
                return false;
            }

        } catch (AmoWrapException $e) {
            return $e->getMessage();
        }
    }


    public static function writeToLog($data, $title = '', $name = null) {
        $log = "\n------------------------\n";
        $log .= date("d.m.Y G:i:s") . "\n";
        $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
        $log .= print_r($data, 1);
        $log .= "\n------------------------\n";
        $mName = date('Y-m-d');
        if($name) {
            $mName = $name;
        }
        file_put_contents( $_SERVER['DOCUMENT_ROOT'] . '/roistat_'.$mName.'.log', $log, FILE_APPEND);
        return true;
    }

}