<?php

namespace app\controllers;

use app\extensions\VarDumper;
use app\models\Language;
use app\models\Page;
use Yii;
use yii\bootstrap\Nav;
use app\components\MyController;

class SiteController extends MyController
{
    public function actions()
    {
        /*return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => '/uploads/', // Directory URL address, where files are stored.
                'path' => '@webroot/uploads/' // Or absolute path to directory where files are stored.
            ],
            'images-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url' => '/uploads/', // Directory URL address, where files are stored.
                'path' => '@webroot/uploads/', // Or absolute path to directory where files are stored.

            ],
            'file-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => '/files/', // Directory URL address, where files are stored.
                'path' => '@webroot/files/' // Or absolute path to directory where files are stored.
            ],
            'files-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url' => '/files/', // Directory URL address, where files are stored.
                'path' => '@webroot/files/', // Or absolute path to directory where files are stored.

            ]
        ];*/

        return [
            'images-get' => [
                'class' => 'vova07\imperavi\actions\GetImagesAction',
                'url' => 'https://headin.pro/en/uploads/', // Directory URL address, where files are stored.
                'path' => '@webroot/en/uploads/', // Or absolute path to directory where files are stored.
            ],
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => 'https://headin.pro/en/uploads/', // Directory URL address, where files are stored.
                'path' => '@webroot/en/uploads/', // Or absolute path to directory where files are stored.
            ],
        ];
    }

    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionMap()
    {
        $page = Page::find()->select(['id', 'parent_id', 'name', 'alias'])
            ->where('alias <> "/" AND language_id=:language_id', [':language_id' => Language::getLangByUrl('en')->id])
            ->asArray()->all();
        $menu_en = Page::TreeMenu($page, 'en');

        $page = Page::find()->select(['id', 'parent_id', 'name', 'alias'])
            ->where('alias <> "/" AND language_id=:language_id', [':language_id' => Language::getLangByUrl('ru')->id])
            ->asArray()->all();
        $menu_ru = Page::TreeMenu($page, 'ru');
        $menu = array_merge($menu_en, $menu_ru);

        return $this->render('map', ['menu' => $menu]);
    }
}
