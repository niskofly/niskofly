<?php
/**
 * PageUrlRule.php - new.headin.pro
 * Initial version by: BeforyDeath
 * Initial version created on: 25.08.15 16:58
 */

namespace app\components;

use Yii;
use app\models\Language;
use app\models\Page;
use yii\web\UrlRule;

class PageUrlRule extends UrlRule
{
    public function init()
    {
        if ($this->name === null) {
            $this->name = __CLASS__;
        }
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        $url = explode('/', trim($pathInfo, '/'));

        $homeUrl = "/";
        $lang = Language::getCurrent();
        if(isset($lang->alias)){
            $homeUrl .= $lang->alias;
        }
        Yii::$app->homeUrl = $homeUrl;

        $parent_id = null;
        foreach($url as $alias){
            if(!$alias) $alias = '/'; // главная
            $whereString = $parent_id ?
                'alias=:alias AND language_id=:language_id AND parent_id=:parent_id':
                'alias=:alias AND language_id=:language_id AND parent_id is :parent_id';
            $page = Page::find()->where(
                $whereString,
                [
                    ':alias' => $alias,
                    ':language_id' => Language::getCurrent()->id,
                    ':parent_id' => $parent_id
                ]
            )->one();
            if(isset($page->id)){
                $parent_id = $page->id;
            }
        }
        /*if ($page) {
            if ($page->active === 1){
                //return ['page/path', ['path' => $pathInfo]];
                return ['page/view', ['page' => $page]];
            }else{
                return false;
            }
        } else return false;*/
        if ($page) {
            return ['page/view', ['page' => $page]];
        } else return false;
    }
}