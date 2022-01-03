<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\CatalogSection;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Услуги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Service', ['create'], ['class' => 'btn btn-success']) ?>
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
                        return CatalogSection::findOne($data->section)->name;
                    } catch(Exception $e){
                        return "(не установлен)";
                    }
                },
            ],
            'name_ru',
            'name_en',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
