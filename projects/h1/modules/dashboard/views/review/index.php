<?php
use kartik\grid\GridView;

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\grid\GridView;
use app\models\Review;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Reviews');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-index">

    <h1><?= Html::encode($this->title) ?></h1>
	    <?=Html::beginForm(Url::toRoute(['review/copy']),'post') ?>
    <p>

        <?= Html::a('Create Review', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton('Copy selected row ', ['class' => 'btn btn-info','formaction'=>Url::toRoute(['review/copy'])]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'resizableColumns'=>true,
        'columns' => [
            ['class' => '\kartik\grid\SerialColumn'],

//            'id',
            'name',
            'date',
            'rating',
            'text',
                      [
                'attribute'=>'language_id',
                'label'=>Yii::t('app','Язык'),
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($data){
                    return $data->getLanguageName();
                },
            ],
                      [
                'attribute'=>'page_id',
                'label'=>Yii::t('app','Страница'),
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($data){
                    return $data->getPageName();
                },
                'filter' => Review::getPageList()
            ],
            ['class' => '\kartik\grid\CheckboxColumn'],
            ['class' => '\kartik\grid\ActionColumn'],
        ],
    ]); ?>
 <?= Html::endForm() ?> 

</div>
