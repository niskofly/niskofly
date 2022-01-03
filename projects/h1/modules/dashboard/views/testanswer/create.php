<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TestAnswer */

$this->title = 'Create Test Answer';
$this->params['breadcrumbs'][] = ['label' => 'Answer', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>