<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TestLevelName */

$this->title = 'Create Test Item';
$this->params['breadcrumbs'][] = ['label' => 'Test', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>