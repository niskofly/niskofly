<?php
/**
 * PageController.php - new.headin.pro
 * Initial version by: BeforyDeath
 * Initial version created on: 16.08.15 16:36
 */

namespace app\controllers;

use app\extensions\VarDumper;
use app\models\Page;
use Yii;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\components\MyController;

class PageController extends MyController
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($page)
    {
        if (is_file(Yii::getAlias('@app/views/page/' . $page->alias . '.php'))) {

            //Странички с индивидуальным дизайном
            return $this->render($page->alias, ['page' => $page]);
        } else {

            //Странички с дизайном по умолчанию
            return $this->render('view', ['page' => $page]);
        }

    }

    public function actionPath($path)
    {
//        return $this->render('index', ['path' => $path]);
    }

}