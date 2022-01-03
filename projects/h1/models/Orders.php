<?php
    

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property string $date
 * @property string $details
 * @property integer $price
 * @property integer $paid
 * @property string $level
 * @property string $start_date
 * @property string $schedule
 * @property string $phone
 * @property string $email
 * @property string $course
 * @property string $firstname
 * @property string $lastname
 * @property string $url
 * @property integer $id_schedule
 * @property string $status
 * @property string $date_status
 * @property integer $user_id
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) 
        {
            // Place your custom code here
            if ($insert)
            {
                if (empty($this->date)){
                    $this->date = (new \DateTime('now', new \DateTimeZone('Asia/Dubai')))->format('Y-m-d H:i:s');
                }
                $this->paid=0;
                $this->url=htmlentities(Yii::$app->getSecurity()->generateRandomString(20));
                if ($this->details == '' || $this->details===null && $this->id_schedule > 0 )
                {
                    if (isset($this->scheds->start_date) && isset($this->scheds->schedule))
                    {
                        $this->details = 'Start date:'.$this->scheds->start_date.PHP_EOL.'Schedule: '.$this->scheds->schedule;
                    }
                    else
                    {
                        $this->details = 'Default message';
                    }
                }
            }
            $this->date_status = (new \DateTime('now', new \DateTimeZone('Asia/Dubai')))->format('Y-m-d H:i:s');

            return true;
        } else 
        {
            return false;
        }
    }



    public function getScheds()
    {
        return $this->hasOne(Sched::className(), ['id' => 'id_schedule']);
    }

    public function getAutopays()
    {
        return $this->hasOne(AutopayDetails::className(), ['order_id' => 'id']);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'date_status'], 'safe'],
            [['details'], 'string'],
            [['email'],'email'],
            [['phone'], 'string'],
//             ['phone', 'match', 'pattern' => '/^(+971)(\d{2})[-](\d{7})/', 'message' => 'Телефон должен быть в формате +971-XX-XXXXXХХ'],
            [['price', 'user_id','firstname','lastname','course','email','phone'], 'required'],
            [['price', 'paid', 'id_schedule', 'user_id'], 'integer'],
            [['level', 'start_date', 'schedule'], 'string', 'max' => 255],
            [[ 'email', 'course', 'firstname', 'lastname', 'url'], 'string', 'max' => 250],
            [['status'], 'string', 'max' => 100],
        ];
    }
    
    
    public function copySelectedRow($selection)
    {
        $result=false;                
        $model = Orders::findOne($selection);
        if ( $model !== null) 
        {
            $i=0;
            foreach($model as $key=>$value)
            {
                if ($i!=0) 
                {
                    $names .= '`'.$key.'`,';                
                }
                $i++;
            }
            $names = substr($names, 0, -1);
            $sql='insert into '.$model->tableName().' ('.$names.')
                  Select
                  '.$names.'
                  from '.$model->tableName().'
                  where id='.$selection[0];
            $result = Yii::$app->db->createCommand($sql)->execute();
        }  
        return $result;
    }
    

    public function getAllCoursesGroup()
    {
        $model=new CoursesGroup();
        
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'date' => Yii::t('app', 'Date'),
            'details' => Yii::t('app', 'Details'),
            'price' => Yii::t('app', 'Price'),
            'paid' => Yii::t('app', 'Paid'),
            'level' => Yii::t('app', 'Level'),
            'start_date' => Yii::t('app', 'Start Date'),
            'schedule' => Yii::t('app', 'Schedule'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'course' => Yii::t('app', 'Course'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'url' => Yii::t('app', 'Url'),
            'id_schedule' => Yii::t('app', 'Id Schedule'),
            'status' => Yii::t('app', 'Status'),
            'date_status' => Yii::t('app', 'Date Status'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    public function getRowColor()
    {
            if ($this->status=='Новый заказ')
             {
                 $result=['style'=>'background-color:#f2efac;'];
             }
             else if ($this->status=='Отправлен Email')
             {
                 $result=['style'=>'background-color:#c9f5c6;'];
                 
             }
             else if ($this->status=='Оплачено')
             {
                 $result=['style'=>'background-color:#c9f5f6;'];
                 
             }
             else
             {
                 $result=['style'=>'background-color:#a37eab;'];
                 
             }
             return $result;
    }

    public function payLinkAutopay()
    {
        $subject='Payment link from Headway Institute';
	    $to=$this->email;
        Yii::$app->mailer->compose('paylinkAutopay',['model'=>$this])
        ->setTo($to)
        ->setFrom([Yii::$app->params['adminEmail'] => 'Headway Institute'])
        ->setSubject($subject)
        ->send();
        $this->status='Отправлен Email';
        if ($this->save())
        {
            return true;
        }
        else
        {
            return false;
        }

    }
    

    public function payLink()
    {
        $subject='Payment link from Headway Institute';
	    $to=$this->email;
        Yii::$app->mailer->compose('paylink',['model'=>$this])
        ->setTo($to)
        ->setFrom([Yii::$app->params['adminEmail'] => 'Headway Institute'])
        ->setSubject($subject)
        ->send();
        $this->status='Отправлен Email';
        if ($this->save())
        {
            return true;
        }
        else
        {
            return false;
        }
        

    }

}