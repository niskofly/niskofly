<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "catalog_section".
 *
 * @property integer $id
 * @property string $name
 * @property string $title_ru
 * @property string $title_en
 * @property string $title_price_ru
 * @property string $title_price_en
 */
class CatalogSection extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'title_ru', 'title_en', 'title_price_ru', 'title_price_en'], 'string', 'max' => 256],
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
            'name' => Yii::t('app', 'Название'),
            'title_ru' => Yii::t('app', 'Заголовок столбца «услуга»'),
            'title_en' => Yii::t('app', 'Заголовок столбца «услуга»'),
            'title_price_ru' => Yii::t('app', 'Заголовок столбца «цена»'),
            'title_price_en' => Yii::t('app', 'Заголовок столбца «цена»'),
        ];
    }

    public function getServiceTitle()
    {
        $lang = Language::getCurrent();
        return trim($this->getAttribute("title_".$lang->alias));
    }

    public function getPriceTitle()
    {
        $lang = Language::getCurrent();
        return trim($this->getAttribute("title_price_".$lang->alias));
    }

}
