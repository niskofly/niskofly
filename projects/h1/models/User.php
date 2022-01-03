<?php

namespace app\models;

use dektrium\user\models\User as BaseUser;

class User extends BaseUser
{
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // add field to scenarios
        $scenarios['create'][] = 'phone';
        $scenarios['update'][] = 'phone';
        $scenarios['register'][] = 'phone';


        return $scenarios;
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['phone'] = \Yii::t('app', 'Телефон');
        return $labels;
    }

    public function rules()
    {
        $rules = parent::rules();
        // add some rules
        $rules['fieldRequired'] = ['phone', 'required'];
        $rules['fieldLength'] = ['phone', 'string', 'max' => 256];
//		print_r($rules);
        return $rules;
    }
}