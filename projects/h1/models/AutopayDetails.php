<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "autopay_details".
 *
 * @property integer $id
 * @property integer $autopay_id
 * @property string $pay_date
 * @property string $pay_sum
 * @property integer $order_id
 *
 * @property Autopay $autopay
 * @property Orders $order
 */
class AutopayDetails extends \yii\db\ActiveRecord
{
    public $emailSent = 0;
    public $paid = 0;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'autopay_details';
    }
    
    public function scenarios()
    {
        return [
            'add' => ['autopay_id'],
            'email' => ['order_id'],
            'default' => ['pay_date', 'pay_sum'],
            ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['autopay_id'], 'required','on'=>'add'],
            [['autopay_id', 'order_id'], 'integer'],
            [['pay_date', 'pay_sum'], 'required'],
            [['pay_date'], 'safe'],
            [['pay_sum'], 'integer'],
            [['pay_date'],'date','format'=>'php:Y-m-d','on'=>'email'],
            [['pay_date'],'date','format'=>'php:d.m.Y'],
            [['autopay_id'], 'exist', 'skipOnError' => true, 'targetClass' => Autopay::className(), 'targetAttribute' => ['autopay_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }
    
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) 
        {
            if ($this->pay_date != null)
            {
                if ($this->scenario !='email' )
                {
                    $date = explode('.', $this->pay_date);
                    $this->pay_date = $date[2].'-'.$date[1].'-'.$date[0];
                }
            }
            else
            {
                $this->pay_date = date('Y-m-d');
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
		$model = AutopayDetails::findOne($selection);
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
    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'autopay_id' => Yii::t('app', 'Autopay ID'),
            'pay_date' => Yii::t('app', 'Pay Date'),
            'pay_sum' => Yii::t('app', 'Pay Sum'),
            'order_id' => Yii::t('app', 'Order ID'),
        ];
    }

	/**
	*  добавим метод возвращающий значение из поля name по связи hasOne, пригодится во вьюшках и грид вью
	*  раскомментируйте если надо 
	*/
	/*
	public function getAutopayName()
	{
		$Autopay = $this->Autopay;
		return $Autopay ? $Autopay->name : '';
	
	}
	*/
	
	
	/**
	*  добавим метод возвращающий список имен со связи hasOne , пригодится при сортировке 
	*
	*/
	/*
	public function getAutopayList()
	{
			
		    $Autopay =  тут_имя_класса_модели::find()
            ->select(['id', 'name'])
            ->distinct(true)
            ->all();

			return ArrayHelper::map($Autopay, 'id', 'name');
			
	}
	*/
	
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutopay()
    {
        return $this->hasOne(Autopay::className(), ['id' => 'autopay_id']);
    }

	/**
	*  добавим метод возвращающий значение из поля name по связи hasOne, пригодится во вьюшках и грид вью
	*  раскомментируйте если надо 
	*/
	/*
	public function getOrderName()
	{
		$Order = $this->Order;
		return $Order ? $Order->name : '';
	
	}
	*/
	
	
	/**
	*  добавим метод возвращающий список имен со связи hasOne , пригодится при сортировке 
	*
	*/
	/*
	public function getOrderList()
	{
			
		    $Order =  тут_имя_класса_модели::find()
            ->select(['id', 'name'])
            ->distinct(true)
            ->all();

			return ArrayHelper::map($Order, 'id', 'name');
			
	}
	*/
	
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }


}
