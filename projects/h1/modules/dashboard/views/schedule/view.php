<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\CatalogSection;
use app\models\Service;

/* @var $this yii\web\View */
/* @var $model app\models\Service */

$this->title = 'Schedule: ' . $model->getStartDates();
$this->params['breadcrumbs'][] = ['label' => 'Schedule', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-view">

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
                'value' => CatalogSection::findOne($model->section_id)->name
            ],
            [
                'label' => Yii::t('app', 'Уровень'),
                'value' => Service::findOne($model->service_id)->getName()
            ],
            [
                'label' => Yii::t('app', 'Даты начала'),
                'value' => $model->getStartDates()
            ],
            [
                'label' => Yii::t('app', 'Расписание'),
                'value' => $model->getSchedule()
            ],
            'price'
        ],
    ]) ?>

</div>
