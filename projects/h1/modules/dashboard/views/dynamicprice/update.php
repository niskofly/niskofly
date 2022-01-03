<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DynamicPrice */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Dynamic Price',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dynamic Prices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="dynamic-price-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
