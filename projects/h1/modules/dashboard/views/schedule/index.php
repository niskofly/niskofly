<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\CatalogSection;
use app\models\Service;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Расписание';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => Yii::t('app', 'Раздел'),
                'content' => function($data){
                    try {
                        return CatalogSection::findOne($data->section_id)->name;
                    } catch(Exception $e){
                        return "(не установлен)";
                    }
                },
            ],
            [
                'label' => Yii::t('app', 'Уровень'),
                'content' => function($data){
                    try {
                        return Service::findOne($data->service_id)->getName();
                    } catch(Exception $e){
                        return "(не установлен)";
                    }
                },
            ],
            'schedule',
            'price',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
