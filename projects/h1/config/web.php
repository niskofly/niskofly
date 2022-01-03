<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'headin',
    'name' => 'Headway Institute',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log','devicedetect','assetsAutoCompress'],
    'language' => 'ru-RU',
    'timeZone' => 'Asia/Dubai',
    'components' => [
	    'devicedetect' => [
		'class' => 'alexandernst\devicedetect\DeviceDetect'
		],
        'assetsAutoCompress' =>
        [
            'class'         => '\skeeks\yii2\assetsAuto\AssetsAutoCompressComponent',
            'enabled'                       => false,


        ],
        'assetManager' => [
            'bundles' => [
//                'yii\web\JqueryAsset' => [
//                    'js'=>[]
//                ],
//                'yii\bootstrap\BootstrapPluginAsset' => [
//                    'js'=>[]
//                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => []
                ]
            ]
        ],
        'request' => [
            'class' => 'app\components\LanguageRequest',
            'cookieValidationKey' => 'W_zAYilDDIeeE9mPjJArdb6LNmBnqUNe'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
//            'class' => 'app\components\User',
            'identityClass' => 'dektrium\user\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/user/register'],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'page/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.

            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'courses@headin.pro',
                'password' => 'He@dway12345',
                'port' => '587',
                'encryption' => 'tls'
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'class' => 'app\components\LanguageUrlManager',
            'rules' => [
                'subscription' => 'subscription/create',
                'feedback' => 'feedback/create',
                'feedback_popup' => 'feedback/popup',
                'search' => 'search/search',
                // dektrium/yii2-user
                'user/login' => 'user/security/login',
                'user/logout' => 'user/security/logout',
                'user/register' => 'user/registration/register',
                'user/resend' => 'user/registration/resend',
                'user/forgot' => 'user/recovery/request',
                'user/admin' => 'user/admin/index',
                'user/profile' => 'user/settings/profile',
                'user/mycourse' => 'user/settings/mycourse',
                'dashboard/<controller>' => 'dashboard/<controller>/index',
                'sitemap.xml' => 'sitemap/index',
                /*'sitemap' => 'site/map',*/

                'GET,POST tests/<id:\d+>/<number:\d+>' => 'tests/question',
                'tests/<id:\d+>/result' => 'tests/result',
                'tests/my' => 'tests/myresults',

                ['class' => 'yii\rest\UrlRule', 'controller' => 'news'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'questions'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'tests'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'review'],
                ['class' => 'app\components\PageUrlRule'],
                '<controller>/<action>' => '<controller>/<action>',

                'gii' => 'gii/index',
            ],
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6LcFHZAUAAAAAMf29VO0OqgbzQudol-nhl8MCpDz',
            'secret' => '6LcFHZAUAAAAAAJhbE7Z4p15FHq1Ef5gytmsb_LQ',
        ],
    ],
    'modules' => [
        'dashboard' => [
            'class' => 'app\modules\dashboard\Module',
        ],
        'gridview' => [
        'class' => '\kartik\grid\Module'
		],
        'user' => [
            'class' => 'dektrium\user\Module',
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin','maxmax'],
            'enableConfirmation' => false,
            'enableUnconfirmedLogin' => true,
//            'enableRegistration' => true,
//            'enableFlashMessages' => true,
            'mailer' => [
                'sender' => 'courses@headin.pro',
                'welcomeSubject' => 'Welcome subject',
                'confirmationSubject' => 'Confirmation subject',
                'reconfirmationSubject' => 'Email change subject',
                'recoverySubject' => 'Recovery subject',
            ],
            'modelMap' => [
                'User' => 'app\models\User',
            ],
//            'urlPrefix' => 'user',
//            'urlRules' => [],
            'controllerMap' => [
                'admin' => [
                    'class' => 'dektrium\user\controllers\AdminController',
                    'layout' => '@app/modules/dashboard/views/layouts/main.php',
                ],
                'registration' => 'app\controllers\user\RegistrationController'
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) 
{
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => [$_SERVER['REMOTE_ADDR'], '127.0.0.1', '::1','*'],
      	'generators'=>[
	      	'model'=>[
		      	'class'=>'yii\gii\generators\model\Generator',
		      	'templates'=>[ 'myModel'=>'@app/myTemplate/model'],
	      	],
		  	'crud'=>[
			  	'class'=>'yii\gii\generators\crud\Generator',
			  	'templates'=>['myCrud'=>'@app/myTemplate/crud']
		  	]
	     
      	]
    ];
}

return $config;
