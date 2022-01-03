<?php

namespace app\controllers;


use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use app\models\Review;
use app\models\Page;
use app\models\Language;
use yii\web\NotFoundHttpException;


class ReviewController extends Controller
{
    public function actionCreate()
    {

        $model = new Review;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
        }
        return $this->redirect('/review', 302);
    }

    public function actionIndex()
    {
        $query = Review::find()->orderBy(['id' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count()
        ]);
        $pages->setPageSize(10);
        $reviews = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', [
            'model' => new Review(),
            'reviews' => $reviews,
            'page' => $this->getPage(),
            'pages' => $pages
        ]);
    }

    public function actionView($id)
    {
        $model = Review::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException;
        }

        $page = $this->getPage();
        $path = $page->getPath(True);
        $path[] = $model->name;

        return $this->render('view', [
            'review' => $model,
            'page' => $page,
            'path' => $path
        ]);
    }

    protected function getPage()
    {
        $lang = Language::getCurrent();
        return Page::findOne([
            'alias' => 'reviews',
            'language_id' => $lang->id
        ]);
    }

}
