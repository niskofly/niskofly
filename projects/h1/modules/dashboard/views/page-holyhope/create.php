<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PageHolyhope */

$this->title = 'Create Page Holyhope';
$this->params['breadcrumbs'][] = ['label' => 'Page Holyhopes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-holyhope-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
