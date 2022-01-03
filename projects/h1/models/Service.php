<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "catalog_service".
 *
 * @property integer $id
 */
class Service extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section'], 'integer', 'min' => 0],
            [['name_ru', 'name_en', 'price'], 'required'],
            [['name_ru', 'name_en'], 'string', 'max' => 256],
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
            'section' => Yii::t('app', 'Раздел'),
            'name_ru' => Yii::t('app', 'Название'),
            'name_en' => Yii::t('app', 'Название'),
            'price' => Yii::t('app', 'Цена'),
        ];
    }

    public function getName()
    {
        $lang = Language::getCurrent();
        return trim($this->getAttribute("name_".$lang->alias));
    }

}
