<?php
/**
 * Created by PhpStorm.
 * User:
 * Date: 30.11.16
 * Time: 21:00
 */

namespace app\components;

use Yii;
use yii\web\Controller;
use app\models\Language;

class MyController extends Controller
{
    public function beforeAction($action)
    {
        $request = Yii::$app->request;
        $lang = Language::getCurrent();

        //Аналог .htaccess
        if ($request->url != '/') {

            // Redirect со слешом на без слеша
            if (substr($request->url, -1) == '/') {
                $this->redirect(substr($request->url, 0, -1), 301);
            }

            // Redirect если index.php
            $lastUrlChunk = trim($request->url, '/');
            $lastUrlChunk = explode('/', $lastUrlChunk);
            $lastUrlChunk = end($lastUrlChunk);
            if ($lastUrlChunk == 'index.php') {
                $this->redirect(str_ireplace('/index.php', '', $request->url), 301);
            }

            //В адресной строке всегда должен быть указан язык
            $urlLang = trim($request->url, '/');
            $urlLang = explode('/', $urlLang);
            $urlLang = array_shift($urlLang);
            if ($urlLang != $lang->alias) {
                $this->redirect('/' . $lang->alias . $request->url, 301);
            }
        }

        return parent::beforeAction($action);
    }

}