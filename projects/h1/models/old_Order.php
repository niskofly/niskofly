<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;


/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property string $date
 */
class Order extends ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date',
                'updatedAtAttribute' => false,
                'value' => new Expression('CURRENT_TIMESTAMP()'),
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['details'], 'string'],
            [['price'], 'integer', 'min' => 0],
            [['paid'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'date' => Yii::t('app', 'Время заказа'),
            'level' => Yii::t('app', 'Уровень'),
            'start_date' => Yii::t('app', 'Даты начала'),
            'schedule' => Yii::t('app', 'Расписание'),
            'price' => Yii::t('app', 'Цена'),
            'paid' => Yii::t('app', 'Оплачено'),
        ];
    }

    public function getOrderNumberDisplay()
    {
        return "Заказ № " . $this->id;
    }
}
