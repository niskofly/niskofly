<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use \kartik\grid\GridView;
use app\models\Courses;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CoursesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Courses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courses-index">

    <h1><?= Html::encode($this->title) ?></h1>
    	<?=Html::beginForm(Url::toRoute(['courses/copy']),'post') ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Courses'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton('Copy selected row ', ['class' => 'btn btn-info','formaction'=>Url::toRoute(['courses/copy'])]) ?>

    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'name',
            [
                'attribute'=>'id_page',
                'label'=>Yii::t('app','Страница'),
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($data){
                    return $data->getPageName();
                },
                'filter'=>Courses::getPageList(1),
            ],
            'week',
            'academic_hour',
            [
                'attribute'=>'language_id',
                'label'=>Yii::t('app','Язык'),
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($data){
                    return $data->getLanguageName();
                },
                'filter'=>Courses::getLanguageList(),
            ],
            // 'data',
            // 'user_id',
			['class' => '\kartik\grid\CheckboxColumn'],
            ['class' => '\kartik\grid\ActionColumn'],
        ],
    ]); ?>
     <?= Html::endForm() ?> 
</div>
