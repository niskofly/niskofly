<?php
 if (getenv('X_ENV') == 'DEV') {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
} else {
    error_reporting(0);
    //Боевой
    defined('YII_DEBUG') or define('YII_DEBUG', false);
    defined('YII_ENV') or define('YII_ENV', 'prod');
}



require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

//Begin roistat
require_once (__DIR__ . '/../roistat/AmoCRM_Wrap/autoload.php');
//End roistat

$config = require(__DIR__ . '/../config/web.php');
(new yii\web\Application($config))->run();
