<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\CatalogSection;

/* @var $this yii\web\View */
/* @var $model app\models\Service */

$this->title = $model->name_ru;
$this->params['breadcrumbs'][] = ['label' => 'Catalog Service', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog_service-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => Yii::t('app', 'Раздел'),
                'value' => CatalogSection::findOne($model->section)->name
            ],
            'name_ru',
            'name_en',
        ],
    ]) ?>

</div>
