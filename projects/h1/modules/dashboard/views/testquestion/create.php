<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TestQuestion */

$this->title = 'Create Test Question';
$this->params['breadcrumbs'][] = ['label' => 'Question', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>