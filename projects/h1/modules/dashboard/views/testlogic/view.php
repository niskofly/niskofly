<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TestQuestion */

$this->title = 'Test Logic:';
$this->params['breadcrumbs'][] = ['label' => 'Test Logic', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logic-view">

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
            'test_id',
            'points_min',
            'points_max',
            'ordering',
            [
                'label' => Yii::t('app', 'Результат'),
                'value' => $model->getResult(),
                'format' => 'html'
            ],
        ],
    ]) ?>



</div>
