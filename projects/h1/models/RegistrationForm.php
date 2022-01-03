<?php

namespace app\models;




class RegistrationForm extends \dektrium\user\models\RegistrationForm
{
    /**
     * Add a new field
     * @var string
     */
    public $phone;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules['fieldRequired'] = ['phone', 'required'];
        $rules['fieldLength'] = ['phone', 'string', 'max' => 256];
        $rules['usernamePattern'] = ['username', 'string','max' => 255];
        unset($rules['usernameRequired']);
        return $rules;
    }

    /**
     * Loads attributes to the user model. You should override this method if you are going to add new fields to the
     * registration form. You can read more in special guide.
     *
     * By default this method set all attributes of this model to the attributes of User model, so you should properly
     * configure safe attributes of your User model.
     *
     * @param User $user
     */
    protected function loadAttributes(User $user)
    {
        $user->setAttributes($this->attributes);
        $user->username = $user->email;
    }

    /**
     * @inheritdoc
     */
/*
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['phone'] = \Yii::t('app', 'Телефон');
        return $labels;
    }
*/

    /**
     * Registers a new user account.
     * @return bool
     */

/*
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }
		
//		$user = Yii::createObject(User::className());		

        $this->user->setAttributes([
            'email' => $this->email,
            'username' => $this->username,
            'password' => $this->password,
            'phone' => $this->phone
        ]);

        return $this->user->register();
    }
*/


}