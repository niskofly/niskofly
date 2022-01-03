<?php

namespace app\widgets;

use yii\base\Widget;
use app\models\Feedback;

class SimpleCouponFormWidget extends Widget
{
	// тип формы купона строчкой=1 формой справа=2
	public $type;
	public $course;
	
    public function run()
    {
        $model = new Feedback();
        if ($this->type=='2')
		{
        	return $this->render('simple_coupon_form2', ['model' => $model,'course'=>$this->course]);
        }
        else
        {
       		 return $this->render('simple_coupon_form1', ['model' => $model,'course'=>$this->course]);
        }
        
    }
}