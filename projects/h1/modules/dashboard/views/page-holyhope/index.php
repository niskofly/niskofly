<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PageHolyhopeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Page Holyhopes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-holyhope-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Page Holyhope', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'page.name',
            'holyhope_id',
            'holyhope_name',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
