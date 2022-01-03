<?php

namespace app\controllers;

use Yii;
use app\components\MyController;
use app\models\Page;

class SearchController extends MyController
{
    public function actionSearch()
    {
        $params = Yii::$app->request->queryParams;
        $pages = [];
        if(isset($params['q'])) {
            $q = $params['q'];
            $pages = Page::find()
                ->where(['or',
                    [
                    'like', 'name', $q
                ],[
                    'like', 'content', $q
                ]])
            ->all();
        }
        return $this->render('view', ['pages' => $pages]);
    }
}
