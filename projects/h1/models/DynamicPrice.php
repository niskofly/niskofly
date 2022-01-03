<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "dynamicPrice".
 *
 * @property integer $id
 * @property integer $daysBefore
 * @property integer $discount
 * @property integer $active
 */
class DynamicPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dynamicPrice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['daysBefore', 'discount', 'active'], 'required'],
            [['daysBefore', 'discount', 'active'], 'integer'],
        ];
    }
    
    
    public function copySelectedRow($selection)
	{
		$result=false;				
		$model = DynamicPrice::findOne($selection);
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
            'daysBefore' => Yii::t('app', 'Days Before'),
            'discount' => Yii::t('app', 'Price with Discount'),
            'active' => Yii::t('app', 'Active'),
        ];
    }


}
