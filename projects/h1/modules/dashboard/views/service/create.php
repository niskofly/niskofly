<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Service */

$this->title = 'Create Service';
$this->params['breadcrumbs'][] = ['label' => 'Catalog Service', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog_service-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
