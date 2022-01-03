<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Subscription;

class SubscriptionController extends Controller
{
    public function actionCreate()
    {
        $model = new Subscription;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->render('view', ['model' => $model]);
        } else {
            return $this->render('create', ['model' => $model]);
        }
    }
}
?>