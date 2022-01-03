<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TestAnswer */

$this->title = 'Create Test Logic';
$this->params['breadcrumbs'][] = ['label' => 'Logic', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logic-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>