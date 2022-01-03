<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test_level".
 *
 * @property integer $id
 * @property integer $test_id
 * @property string $level_name_id
 * @property integer $points_minimum
 * @property integer $points_maximum
 */
class TestLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['test_id', 'points_minimum', 'points_maximum', 'level_name_id'], 'integer'],
        ];
    }

    public static function setLevelByTest($testId, $data)
    {

        if ($data) {

            //Транзакция

            $transaction = Yii::$app->db->beginTransaction();
            try {

                //Очистка предыдущих значений
                self::deleteAll('test_id = :test_id', [':test_id' => $testId]);

                foreach ($data as $k => $item) {

                    $model = new self;
                    $model->test_id = $testId;
                    $model->level_name_id = $k;
                    $model->points_minimum = $item['min'];
                    $model->points_maximum = $item['max'];
                    $model->save();
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevelName()
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
            'test_id' => 'Test ID',
            'level_name_id' => 'Level Name ID',
            'points_minimum' => 'Points Minimum',
            'points_maximum' => 'Points Maximum',
        ];
    }
}
