<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "page_holyhope".
 *
 * @property int $id
 * @property int $page_id
 * @property array $page_ids
 * @property int $holyhope_id
 * @property array $holyhope_ids
 */
class PageHolyhope extends \yii\db\ActiveRecord
{
    public $page_ids = [];
    public $holyhope_ids = [];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page_holyhope';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['page_id'], 'required'],
            [['page_id'], 'integer'],
            [['holyhope_id'], 'required'],
            [['holyhope_id'], 'integer'],
            [['page_ids'],'each','rule' => ['string']],
            [['holyhope_ids'],'each','rule' => ['string']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public  function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'holyhope_id' => 'Page ID',
            'page_ids' => 'Page ID',
            'holyhope_ids' => 'Page ID',
        ];
    }
    public static function bit_analysis($n){
        $bin_powers = array();
        for($bit = 0; $bit<10; $bit++){
            $bin_power = 1 << $bit;
            if($bin_power & $n) $bin_powers[$bit] = $bin_power;
        }
        return $bin_powers;
    }
    public static function getDayString($n,$lang){
        $days_ru = ['Пн' => 1, 'Вт' => 2, 'Ср' => 4, 'Чт' => 8, 'Пт' => 16, 'Сб' => 32, 'Вс' => 64];
        $days_eng = ['Mon' => 1, 'Tue' => 2, 'Wed' => 4, 'Thu' => 8, 'Fri' => 16, 'Sat' => 32, 'Sun' => 64];
        $days_current = PageHolyhope::bit_analysis($n);
        if ($lang == 'ru'){
            $days = $days_ru;
        }else{
            $days = $days_eng;
        }
        $days_string = '';
        foreach ( $days_current as $day_current){
            $days_string .=   array_search( $day_current, $days).', ';
        }
        return substr($days_string,0,-2);

    }
    public static function getHolyhopeByIds( $holyhope_id,$page_id){
        return PageHolyhope::find()->select('holyhope_id')->where(['page_id' => $page_id,'holyhope_id' => $holyhope_id])->one();
    }
    public static function getHolyhopeListById($page_id){
        $pageHolyhopes = PageHolyhope::find()->select('holyhope_id')->where(['page_id' => $page_id])->asArray()->all();
        $result = [];
        foreach ($pageHolyhopes as $pageHolyhope){
            $result[] = $pageHolyhope['holyhope_id'];
        }
        return $result;
    }

    static function getHolyhopeByPage($page_id){
        $pageHolyhopes = PageHolyhope::find()->select('holyhope_id')->where(['page_id' => $page_id])->asArray()->all();
        $result = [];
        foreach ($pageHolyhopes as $pageHolyhope){
            $result[] = $pageHolyhope['holyhope_id'];
        }
        return $result;
    }

    public static function getPagesByHolyhope($holyhope_id){
        $pageHolyhopes = PageHolyhope::find()->select('page_id')->where(['holyhope_id' => $holyhope_id])->asArray()->all();
        $result = [];
        foreach ($pageHolyhopes as $pageHolyhope){
            $result[] = $pageHolyhope['page_id'];
        }
        return $result;
    }
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    public static function getPagesList()
    {
        $page = Page::find()
            ->select(['id', 'name'])
            ->distinct(true)
            ->all();

//			print_r($page);
        return ArrayHelper::map($page, 'id', 'name');
    }


    public static function getHolyhopeList(){

        $request = [
            'types' => 'Group,MiniGroup',
            'dateFrom' => date('Y-m-d',strtotime('now') - 2),
            'authkey' => 'w3yxL8yT5Tw5jJb4JerIdPX6XW7gvocgcq7MQuA0hBI2yhSFx2DM1UMHqPvVh5ln'
        ];
        include('./../holyhope-api/holyhope-timetable.php');

        return ArrayHelper::map($Response["EdUnits"], 'Id', 'Name');

    }

    public static function getHolyhopeListAll(){
        $pageHolyhopes = PageHolyhope::find()->select('holyhope_id')->asArray()->all();
        $result = [];
        foreach ($pageHolyhopes as $pageHolyhope){
            $result[] = (int)$pageHolyhope['holyhope_id'];
        }
        return $result;
    }

}
