<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\TestQuestion;

/**
 * This is the model class for table "test".
 *
 * @property integer $id
 * @property integer $language_id
 * @property string $name
 * @property boolean $active
 * @property integer $ordering
 * @property string $description_ru
 * @property string $description_en
 */

class Test extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'language_id'], 'required'],
            [['name'], 'string', 'max' => 512],
            [['description'], 'string', 'max' => 65535],
            [['active'], 'boolean'],
            [['ordering', 'language_id'], 'integer', 'min' => 0]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'language_id' => 'Language',
            'name' => 'Name',
            'active' => 'Active',
            'ordering' => 'Ordering',
            'description' => 'Description',
        ];
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogic()
    {
        return $this->hasOne(TestLogic::className(), ['test_id'=>'id']);
    }

    public function getQuestions()
    {
        $obj = Test::findOne($this->id);
        $r = array();
        $obQuestion = TestQuestion::find()->where(['test_id' => $obj->id])->all();
        foreach($obQuestion as $question) {
            $r[] = [
                'id' => $question["id"],
                'name' => $question["name"],
                'active' => $question["active"],
                'ordering' => $question["ordering"]
            ];
        }
        return $r;
    }

    public function getQuestionCount()
    {
        return count($this->getQuestions());
    }

    public function getDescription()
    {
        $lang = Language::getCurrent();
        return trim($this->getAttribute("description"));
    }

}