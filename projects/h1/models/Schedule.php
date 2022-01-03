<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Service;

/**
 * This is the model class for table "schedule".
 *
 * @property integer $id
 */
class Schedule extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_id', 'service_id', 'start_date_from', 'start_date_to', 'schedule_ru', 'schedule_en', 'price'], 'required'],
            [['section_id'], 'integer', 'min' => 0],
            [['service_id'], 'integer', 'min' => 0],
            [['start_date_from', 'start_date_to'], 'safe'],
            [['price'], 'number', 'min' => 0],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'section_id' => Yii::t('app', 'Раздел'),
            'service_id' => Yii::t('app', 'Уровень'),
            'start_date_from' => Yii::t('app', 'Дата начала с …'),
            'start_date_to' => Yii::t('app', 'Дата начала до …'),
            'schedule_ru' => Yii::t('app', 'Расписание'),
            'schedule_en' => Yii::t('app', 'Расписание'),
            'price' => Yii::t('app', 'Цена'),
        ];
    }

    public function getLevel()
    {
        $service = Service::findOne($this->id);
        return $service->getName();
    }

    public function getStartDates()
    {
        $start_date_from = new \DateTime($this->start_date_from);
        $start_date_to = new \DateTime($this->start_date_to);
        return $start_date_from->format("j.m")." — ".$start_date_to->format("j.m.Y");
    }

    public function getSchedule()
    {
        $lang = Language::getCurrent();
        return trim($this->getAttribute("schedule_".$lang->alias));
    }

}
