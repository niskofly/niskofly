<?php

namespace app\widgets;

use yii\base\Widget;
use app\models\Subscription;

class SubscriptionWidget extends Widget
{
    public function run()
    {
        $model = new Subscription();
        return $this->render('subscription', ['model' => $model]);
    }
}