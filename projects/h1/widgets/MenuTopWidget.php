<?php
/**
 * MenuTopWidget.php - new.headin.pro
 * Initial version by: BeforyDeath
 * Initial version created on: 28.08.15 10:25
 */
namespace app\widgets;

use Yii;
use app\models\Language;
use app\models\Page;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class MenuTopWidget extends Widget
{
    public function run()
    {
        $page = Page::find()->select(['id', 'parent_id', 'name', 'alias', 'active'])
            ->where(
                'alias <> "/" AND language_id=:language_id AND active=1',
                [':language_id'=> Language::getCurrent()->id]
            )
            ->asArray()->all();
/*
            print_r($page);
            die();
*/
        $menu = Page::TreeMenu($page, Language::getCurrent()->alias);
        echo '<pre>';
        print_r($menu);
        echo '</pre>';
        die();
        return $this->render('menu_top',['result'=> $menu]);
    }
}