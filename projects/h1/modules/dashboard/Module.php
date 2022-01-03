<?php

namespace app\modules\dashboard;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\dashboard\controllers';
    public $layout = 'main';

    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
}
