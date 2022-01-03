<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'controllerMap' => [
        'sendAutopayEmail'    => 'app\commands\SendAutopayEmail',
        'synchronization'    => 'app\commands\synchronization',
    ],
    
    'components' => [
        'urlManager' => [
                'class' => 'yii\web\UrlManager',
                'scriptUrl' => 'https://headin.pro',
                'baseUrl' => 'https://headin.pro',
        ],    

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
];
