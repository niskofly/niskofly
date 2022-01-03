<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DynamicPrice */

$this->title = Yii::t('app', 'Create Dynamic Price');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dynamic Prices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dynamic-price-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
