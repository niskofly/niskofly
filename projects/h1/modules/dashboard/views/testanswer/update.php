<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TestAnswer */

$this->title = 'Update Test Answer: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'TestAnswer', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="answer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>