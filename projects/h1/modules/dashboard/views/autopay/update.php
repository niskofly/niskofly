<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Autopay */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Autopay',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Autopays'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="autopay-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_update', [
        'model' => $model,
        'clientDetailModels' => $clientDetailModel,
    ]) ?>

</div>
