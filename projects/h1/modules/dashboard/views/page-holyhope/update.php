<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PageHolyhope */

$this->title = 'Update Page Holyhope: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Page Holyhopes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="page-holyhope-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
