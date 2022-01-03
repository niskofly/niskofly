<?php
/**
 * LanguageUrlManager.php - new.headin.pro
 * Initial version by: BeforyDeath
 * Initial version created on: 22.08.15 10:17
 */

namespace app\components;

use Yii;
use app\models\Language;
use yii\web\UrlManager;


class LanguageUrlManager extends UrlManager
{
    public function createUrl($params)
    {
        if (isset($params['language'])) {
            $language = Language::findOne(['alias' => $params['language']]);
            if ($language === null) {
                $language = Language::getDefaultLang();
            }
            unset($params['language']);
        } else {
            $language = Language::getCurrent();
        }
        $homeUrl = "/";
        if(isset($language->alias)){
            if ($language->alias != 'en')
            $homeUrl .= $language->alias;
        }
        Yii::$app->homeUrl = $homeUrl;
        if (isset($params['clear'])) {
            unset($params['clear']);
            $url = parent::createUrl($params);
            $url = preg_replace(["/^\/en/","/^\/ru/"], '',$url);
        } else {
            $url = parent::createUrl($params);
        }
        if ($url == '/') {
            return '/' . $language->alias;
        } else {
            return '/' . $language->alias . $url;
        }
    }
}
