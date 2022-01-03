<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CatalogSection */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Catalog Section', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog_section-view">

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
            'name',
            [
                'label' => Yii::t('app', 'Заголовок столбца «услуга»'),
                'value' => $model->getServiceTitle(),
                'format' => 'html'
            ],
            [
                'label' => Yii::t('app', 'Заголовок столбца «цена»'),
                'value' => $model->getPriceTitle(),
                'format' => 'html'
            ],
        ],
    ]) ?>

</div>
