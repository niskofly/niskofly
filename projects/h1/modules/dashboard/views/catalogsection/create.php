<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CatalogSection */

$this->title = 'Create Section';
$this->params['breadcrumbs'][] = ['label' => 'Catalog Section', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog_section-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
