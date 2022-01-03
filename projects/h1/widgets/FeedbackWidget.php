<?php

namespace app\widgets;

use yii\base\Widget;
use app\models\Feedback;

class FeedbackWidget extends Widget
{
    public function run()
    {
        $model = new Feedback();
        return $this->render('feedback', ['model' => $model]);
    }
}