<?php
/**
 * LanguageWidget.php - new.headin.pro
 * Initial version by: BeforyDeath
 * Initial version created on: 24.08.15 11:21
 */

namespace app\widgets;

use app\models\Language;
use app\models\Page;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class LanguageWidget extends Widget
{
    public function run()
    {
        $active = Language::getCurrent()->alias;

        $link = [];
        foreach (['ru', 'en'] as $alias) {
            $options = ['class' => 'lang-' . $alias];
            if ($alias == $active) {
                Html::addCssClass($options, 'active');
            }
            if ($this->checkContent($alias)) {

                   $url = Url::toRoute([Url::to(''), 'clear' => 'yes', 'language' => $alias]);
                   if ($url === '/en') {
                       $link[] = Html::tag('li',
                           Html::a($alias,'/' ),
                           $options, []);
                   }else{
                       $link[] = Html::tag('li',
                           Html::a($alias, Url::toRoute([Url::to(''), 'clear' => 'yes', 'language' => $alias])),
                           $options, []);
                   }




            } else {
                $link[] = Html::tag('li', $alias, $options, []);
            }
        }
        return $this->render('language', ['link' => $link]);
    }

    /**
     * Проверка наличия контента для дургого языка
     *
     * @param $langAlias
     */
    public function checkContent($langAlias)
    {

        $UrlPath = explode('/', \Yii::$app->request->getPathInfo());
        $rootPath = array_shift($UrlPath);

        if (isset($rootPath) && in_array($rootPath, $this->getExcludeUrl()))
        {
            return true;
        }

        if ($langAlias != Language::getCurrent()->alias) {

            $aliasUrl = end($UrlPath);
            if ($aliasUrl) {
                return Page::find()->where(
                    'alias=:alias AND language_id=:language_id',
                    [
                        ':alias' => $aliasUrl,
                        ':language_id' => Language::getLangByUrl($langAlias)->id,
                    ]
                )->one();
            }

        }
        return true;
    }

    /**
     * Страницы сайта которые всегда должны иметь переключатель языков
     * @return array
     */
    protected function getExcludeUrl()
    {
        return[
            'user',
            'tests'
        ];
    }
}