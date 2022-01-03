<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test_level_name".
 *
 * @property integer $id
 * @property integer $language_id
 * @property string $name
 */
class TestLevelName extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_level_name';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['language_id','test_id'], 'integer'],
            [['name','name_tech'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'language_id' => 'Language ID',
            'name' => 'Name',
            'name_tech' => 'Name in dashboard',
            'test_id' => 'Test',
        ];
    }

    static function getAllTests(){
        return Test::find()->all();
    }

    public function getTest()
    {
        return $this->hasOne(Test::className(), ['id' => 'test_id']);
    }
}
