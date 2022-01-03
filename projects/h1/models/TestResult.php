<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "test_results".
 *
 * @property integer $id
 * @property string $date
 * @property string $name
 * @property integer $user_id
 * @property integer test_id
 * @property integer level_name_id
 * @property integer points
 * @property string $result
 */

class TestResult extends ActiveRecord {

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
        return 'test_results';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['result', 'user_id', 'name', 'test_id', 'level_name_id', 'points'], 'required'],
            [['name'], 'string', 'max' => 256],
            [['result'], 'string', 'max' => 4096],
            [['date'], 'safe'],
        ];
    }

    public function getLevel()
    {
        return $this->hasOne(TestLevelName::className(), ['id' => 'level_name_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'result' => 'Result',
            'date' => 'Date',
            'name' => 'Test name'
        ];
    }

}
