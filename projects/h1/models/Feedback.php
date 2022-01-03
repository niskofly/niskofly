<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use himiklab\yii2\recaptcha\ReCaptchaValidator;

/**
 * This is the model class for table "feedback".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $course
 * @property string $message
 */
class Feedback extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback';
    }

    public $pay;
    public $price;
    public $group;
    public $id_schedule;
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone'], 'required'],
            [['name', 'email', 'phone', 'course'], 'string', 'max' => 128],
            [['promocode'], 'string', 'max' => 255],
            [['roistat', 'google'], 'string', 'max' => 250],
            [['message'], 'string', 'max' => 1024],
            [['pay','id_schedule'],'integer'],
            ['email', 'email'],
            [['price','pay','id_schedule','group'],'safe'],
            [['reCaptcha'], ReCaptchaValidator::className()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Имя'),
            'email' => 'E-mail',
            'phone' => Yii::t('app', 'Телефон'),
            'course' => Yii::t('app', 'Выбрать курс'),
            'message' => Yii::t('app', 'Сообщение'),
            'promocode' => Yii::t('app', 'Промокод'),
        ];
    }

    public static function getCourseChoices()
    {
        $c = [
            'English language'=>'English language',
            'Russian language' =>'Russian language',
            'Arabic language'=>'Arabic language',
            'French language'=>'French language',
            'Spanish language'=>'Spanish language',
            'Chinese language'=>'Chinese language',
            'German language'=>'German language',
            'IELTS Preparation course'=>'IELTS Preparation course',
            'TOEFL Preparation course'=>'TOEFL Preparation course',
            
/*
            Yii::t('app', 'Арабский язык') =>
                [
                    Yii::t('app', 'Интенсивные курсы'),
                    Yii::t('app', 'Арабский для детей'),
                    Yii::t('app', 'Корпоративные курсы'),
                ],
            Yii::t('app', 'Английский язык') =>
                [
                    Yii::t('app', 'Интенсивные курсы'),
                    Yii::t('app', 'Английский для детей'),
                    Yii::t('app', 'Корпоративные курсы'),
                    Yii::t('app', 'TOEFL / IELTS'),
                    Yii::t('app', 'Специальные курсы'),
                ],
            Yii::t('app', 'Русский язык') =>
                [
                    Yii::t('app', 'Интенсивные курсы'),
                    Yii::t('app', 'Русский язык для детей'),
                    Yii::t('app', 'Подготовка к тестам'),
                ],
*/
        ];
        $r = [];
        foreach($c as $section => $values) {
            $new_values = [];

/*
            foreach($values as $v) {
                $new_values[$section." / ".$v] = $v;
            }
*/
            $r[$section] = $new_values;
        }
//        return $r;
        return $c;
    }
    
    
    public function mailCoupon()
    {
	    $subject='Your 50AED gift coupon from Headway Institute';
	    $to=$this->email;
        Yii::$app->mailer->htmlLayout= false;
	    Yii::$app->mailer->compose('coupon')
                ->setTo($to)
                ->setFrom([Yii::$app->params['adminEmail'] => 'Headway Institute'])
                ->setSubject($subject)
//                ->setHtmlBody($mailMessage)
                ->send();
                
    }

    public function mailNotify()
    {

        $mailMessage =
            "Имя: ".$this->name."\n".
            "E-mail: ".$this->email."\n".
            "Телефон: ".$this->phone."\n".
            "Курс: ".$this->course."\n".
            "Сообщение: ".$this->message."\n".
    		"google: ".$this->google."\n".
    		"roistat: ".$this->roistat."\n".
            "Промокод: ".$this->promocode
        ;
        $email = "courses@headin.pro";
//      $email = "acidmax76@icloud.com";

        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['adminEmail'] => 'Headway Institute'])
                ->setSubject("Headway Institute: заполнена форма обратной связи")
                ->setTextBody($mailMessage)
                ->send();

            return true;
        } else {
            return false;
        }
    }
    
    public function pay()
    {
        $order = new Orders();
        $order->user_id = Yii::$app->user->getId();
        $order->price = $this->price;
        $order->firstname = $this->name;
        $order->lastname = $this->name;
        $order->course = $this->course;
        $order->email = $this->email;
        $order->phone = $this->phone;
        $order->id_schedule = $this->id_schedule;
        if ($order->save())
        {
            $order->payLink();
        }
        
        
//        $order->
        
    }

    public function afterSave($insert, $changedAttributes)
    {
	    if ($this->message=='Coupon 50 aed')
	    {
		    $this->mailCoupon();
	    }
        $this->mailNotify();
        
        if ($this->pay==1)
        {
            $this->pay();
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
