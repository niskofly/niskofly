<?php

use yii\helpers\Html;
use \kartik\grid\GridView;
use app\models\Page;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pages';
$this->registerMetaTag(['name' => 'description', 'content' => 'test0']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'test1']);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <h1><?= Html::encode($this->title) ?></h1>
	<?=Html::beginForm(Url::toRoute(['page/copy']),'post') ?>
    <p>
        <?= Html::a('Create Page', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton('Copy selected row ', ['class' => 'btn btn-info','formaction'=>Url::toRoute(['page/copy'])]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'resizableColumns'=>true,
        'columns' => [

            'id',
            [
                'attribute'=>'language_id',
                'label'=>Yii::t('app','Язык'),
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($data){
                    return $data->getLanguageName();
                },
                'filter'=>Page::getLanguageList(),
            ],
            [
                'attribute'=>'parent_id',
                'label'=>Yii::t('app','Родительская страница'),
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($data){
                    return $data->getParentName();
                },
                'filter' => Page::getPageList()
            ],
            
            'name',
            'alias',
            'sort',
             ['attribute'=>'updated_at','format'=>['datetime','php:Y-m-d']],
            'active',
			['class' => '\kartik\grid\CheckboxColumn'],
            ['class' => '\kartik\grid\ActionColumn'],
        ],
    ]); ?>
 <?= Html::endForm() ?> 
</div>
