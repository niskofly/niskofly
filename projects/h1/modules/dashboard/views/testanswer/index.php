<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\TestAnswer;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ответы тестов';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="answer-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'testquestion_id',
            'name',
            'points',
            'active',
            'ordering',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

