<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "autopay".
 *
 * @property integer $id
 * @property string $date
 * @property string $firstname
 * @property string $lastname
 * @property string $phone
 * @property string $email
 * @property string $course
 * @property integer $user_id
 *
 * @property AutopayDetails[] $autopayDetails
 */
class Autopay extends \yii\db\ActiveRecord
{
    
    public $summaAutopay;
    public $countDetails;
    public $startDate;
    public $summaPaid;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'autopay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['details'], 'string'],
            [['firstname','lastname','email'], 'required'],
            [['user_id','countDetails'], 'integer'],
            [['user_id'], 'required'],
            [['details'], 'string'],
            [['email'],'email'],
            ['summaAutopay','integer'],
            ['countDetails','integer'],
            [['startDate'],'date','format' => 'php:d.m.Y'],
            [['firstname', 'lastname', 'phone', 'course'], 'string', 'max' => 250],
            
        ];
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $autopayDetails = Yii::$app->request->post('AutopayDetails');
        foreach ($autopayDetails as $item) 
        {
                if ($insert)
                {
                    $modelX=new \app\models\AutopayDetails();
                    $modelX->attributes = $item;
                    $modelX->autopay_id = $this->id;
                }
                else
                {
                    $modelX=\app\models\AutopayDetails::findOne($item['id']);
                    $modelX->attributes = $item;
                }
                $modelX->save();
        }            

    }
    
    public function afterFind()
    {
        $this->summaAutopay = \app\models\AutopayDetails::find()->andWhere(['autopay_id'=>$this->id])->sum('pay_sum');
        $this->countDetails =  \app\models\AutopayDetails::find()->andWhere(['autopay_id'=>$this->id])->count();
        $st = \app\models\AutopayDetails::find()->select(['pay_date'])->andWhere(['autopay_id'=>$this->id])->orderBy('pay_date')->limit(1)->one();
        if ($st)
        {
            $this->startDate = $st->pay_date;
        }
        $this->summaPaid = \app\models\AutopayDetails::find()->joinWith('order')->andWhere(['autopay_details.autopay_id'=>$this->id,'orders.paid'=>1])->sum('orders.price');

    }

    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) 
        {
            if ($insert)
            {    
                $this->date = (new \DateTime('now', new \DateTimeZone('Asia/Dubai')))->format('Y-m-d H:i:s');
                
            }
            if (empty($this->user_id)){
                $this->user_id = 1;
            }

            return true;
            
        } else 
        {
            return false;
        }
    }
    
    public function copySelectedRow($selection)
	{
		$result=false;				
		$model = Autopay::findOne($selection);
		$names = '';
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
			$maxId = Autopay::find()->max('id');
    		$oldId = $model->id;
    		$details = \app\models\AutopayDetails::find()->andWhere(['autopay_id'=>$oldId])->all();
    		foreach($details as $detail)
    		{
        		$i=0;
        		$names='';
        		foreach($detail as $key => $value)
        		{
    				if ($i!=0 && $key != 'autopay_id' && $key != 'order_id') 
    				{
    					$names .= '`'.$key.'`,';				
    				}
    				$i++;            		
        		}
                $names = substr($names, 0, -1);
    			$sql='insert into '.$detail->tableName().' (autopay_id,'.$names.')
    				  Select
    				  '.$maxId.','.$names.'
    				  from '.$detail->tableName().'
    				  where id='.$detail->id;
    			$result = Yii::$app->db->createCommand($sql)->execute();                
    		}
			
		}  
		return $result;
	}
    

    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'date' => Yii::t('app', 'Date'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'course' => Yii::t('app', 'Course'),
            'user_id' => Yii::t('app', 'User ID'),
            'summaAutopay' => Yii::t('app', 'Summa'),
            'countDetails' => Yii::t('app', 'Month'),
            'summaPaid' => Yii::t('app', 'Paid'),
        ];
    }

	/**
	*  добавим метод возвращающий значение из поля name по связи hasOne, пригодится во вьюшках и грид вью
	*  раскомментируйте если надо 
	*/
	/*
	public function getAutopayDetailsName()
	{
		$AutopayDetails = $this->AutopayDetails;
		return $AutopayDetails ? $AutopayDetails->name : '';
	
	}
	*/
	
	
	/**
	*  добавим метод возвращающий список имен со связи hasOne , пригодится при сортировке 
	*
	*/
	/*
	public function getAutopayDetailsList()
	{
			
		    $AutopayDetails =  тут_имя_класса_модели::find()
            ->select(['id', 'name'])
            ->distinct(true)
            ->all();

			return ArrayHelper::map($AutopayDetails, 'id', 'name');
			
	}
	*/
	
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutopayDetails()
    {
        return $this->hasMany(AutopayDetails::className(), ['autopay_id' => 'id']);
    }


}
