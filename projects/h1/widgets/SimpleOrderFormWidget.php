<?php

namespace app\widgets;

use yii\base\Widget;
use app\models\Feedback;

class SimpleOrderFormWidget extends Widget
{
    public $selectedCourse;

    public function run()
    {
        $model = new Feedback();
		if (strpos($this->selectedCourse,'Free Class')!== false)
		{
	        return $this->render('simple_order_form_rec_freeClass', [
    	        'model' => $model,
				'selectedCourse'=>$this->selectedCourse
				]);
			
		}
		elseif (strpos($this->selectedCourse,'Choose Course')!==false)
		{
			   return $this->render('simple_order_form_rec_chooseCourse', [
    	        'model' => $model,
				'selectedCourse'=>$this->selectedCourse
				]);
		}
		else
		{
        return $this->render('simple_order_form', [
            'model' => $model,
            'selectedCourse'=>$this->selectedCourse
        ]);
        }

    }
}