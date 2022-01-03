<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Feedback;
use yii\web\NotFoundHttpException;

class FeedbackController extends Controller
{
    public function actionCreate()
    {
        $model = new Feedback;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            include('../amo-api/handler.php');
            /*print_r($model);
            die();*/

            $model->save();
            return $this->render('view', ['model' => $model]);
        } else {
            return $this->render('create', ['model' => $model]);
        }
    }
    public function actionPopup()
    {
        $model = new Feedback;
        return $this->renderPartial('popup', ['model' => $model]);
    }
}
?>