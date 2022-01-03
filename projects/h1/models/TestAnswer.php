<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\TestQuestion;

/**
 * This is the model class for table "test".
 *
 * @property integer $id
 * @property integer $testquestion_id
 * @property string $name
 * @property boolean $active
 * @property integer $ordering
 * @property integer $points
 */

class TestAnswer extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tests_answers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'testquestion_id', 'points'], 'required'],
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
            'testquestion_id' => 'Question',
            'name' => 'Name',
            'points' => 'Points',
            'active' => 'Active',
            'ordering' => 'Ordering'
        ];
    }

}