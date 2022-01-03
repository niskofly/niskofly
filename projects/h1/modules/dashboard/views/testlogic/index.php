<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\TestAnswer;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Логика тестов';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="logic-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'test_id',
            'points_min',
            'points_max',
            'ordering',
            [
                'label' => Yii::t('app', 'Результат'),
                'format' => 'html',
                'content' => function($data){
                    return $data->getResult();
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

