<?php

namespace app\widgets;

use yii\base\Widget;
use app\models\Feedback;

class SimpleCallbackFormWidget extends Widget
{
    public function run()
    {
        $model = new Feedback();
        return $this->render('simple_callback_form', ['model' => $model]);
    }
}