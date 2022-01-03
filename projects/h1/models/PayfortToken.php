<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payfort_token".
 *
 * @property integer $user_id
 * @property string $code
 * @property integer $created_at
 *
 * @property User $user
 */
class PayfortToken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payfort_token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'code', 'created_at'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['code'], 'string', 'max' => 32],
            [['user_id', 'code'], 'unique', 'targetAttribute' => ['user_id', 'code'], 'message' => 'The combination of User ID and Code has already been taken.'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'code' => 'Code',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setAttribute('created_at', time());
        }

        return parent::beforeSave($insert);
    }

}
