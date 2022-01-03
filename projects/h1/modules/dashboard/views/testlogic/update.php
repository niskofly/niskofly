<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TestLogic */

$this->title = 'Update Test Logic';
$this->params['breadcrumbs'][] = ['label' => 'TestLogic', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'TestLogic', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="logic-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'levelName'=>$levelName
    ]) ?>

</div>