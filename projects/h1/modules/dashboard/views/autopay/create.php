<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Autopay */

$this->title = Yii::t('app', 'Create Autopay');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Autopays'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_form', [
        'model' => $model,
        'clientDetailModel' => $clientDetailModel,
    ]) ?>


