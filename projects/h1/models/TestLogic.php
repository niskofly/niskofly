<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "test_logic".
 *
 * @property integer $id
 * @property integer $test_id
 * @property integer $ordering
 * @property integer $points_min
 * @property integer $points_max
 * @property string $result_ru
 * @property string $result_en
 */
class TestLogic extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_logic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['result', 'test_id'], 'required'],
            [['result'], 'string', 'max' => 4096],
            [['points_min', 'points_max'], 'integer'],
            [['ordering'], 'integer', 'min' => 0]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'test_id' => 'Test',
            'result' => 'Result',
            'points_min' => 'Points minimum',
            'points_max' => 'Points maximum',
            'ordering' => 'Ordering'
        ];
    }

    /**
     * Get Test
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::className(), ['id' => 'test_id']);
    }

    /**
     * Get level by test
     * @return \yii\db\ActiveQuery
     */
    public function getLevelValue()
    {
        return $this->hasMany(TestLevel::className(), ['test_id' => 'test_id']);
    }

    public function getResult()
    {
        $lang = Language::getCurrent();
        return trim($this->getAttribute("result"));
    }

}
