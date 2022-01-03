<?php
/**
 * Created by PhpStorm.
 * User: scriptosaur
 * Date: 06.11.15
 * Time: 13:36
 */

namespace app\controllers;


use Yii;
use yii\data\Pagination;
use app\components\MyController;
use app\models\News;
use app\models\Page;
use app\models\Language;
use yii\web\NotFoundHttpException;


class NewsController extends MyController
{
    public function actionIndex()
    {
        $query = News::find()->orderBy(['date' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count()
        ]);
        $pages->setPageSize(10);
        $reviews = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', [
            'model' => new News(),
            'news' => $reviews,
            'page' => $this->getPage(),
            'pages' => $pages
        ]);
    }

    public function actionView($id)
    {
        $model = News::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException;
        }

        $page = $this->getPage();
        $path = $page->getPath(True);
        $path[] = $model->getName();

        return $this->render('view', [
            'article' => $model,
            'page' => $page,
            'path' => $path
        ]);
    }

    protected function getPage()
    {
        $lang = Language::getCurrent();
        return Page::findOne([
            'alias' => 'news',
            'language_id' => $lang->id
        ]);
    }
}
