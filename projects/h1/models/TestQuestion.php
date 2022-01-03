<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\TestAnswer;

/**
 * This is the model class for table "test question".
 *
 * @property integer $id
 * @property integer $test_id
 * @property string $name
 * @property boolean $active
 * @property integer $ordering
 */

class TestQuestion extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tests_questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'test_id'], 'required'],
            [['name'], 'string', 'max' => 512],
            [['active'], 'boolean'],
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
            'name' => 'Name',
            'active' => 'Active',
            'ordering' => 'Ordering'
        ];
    }

    public function getAnswers()
    {
        $obj = TestQuestion::findOne($this->id);
        $r = array();
        $obAnswer = TestAnswer::find()->where(['testquestion_id' => $obj->id])->all();
        foreach($obAnswer as $answer) {
            $r[] = [
                'id' => $answer["id"],
                'name' => $answer["name"],
                'active' => $answer["active"],
                'ordering' => $answer["ordering"],
                'points' => $answer["points"]
            ];
        }
        return $r;
    }

}