<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use \kartik\grid\GridView;
use app\models\CoursesGroup;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CoursesGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Courses Groups');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courses-group-index">

    <h1><?= Html::encode($this->title) ?></h1>
	<?=Html::beginForm(Url::toRoute(['coursesgroup/copy']),'post') ?>    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Courses Group'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton('Copy selected row ', ['class' => 'btn btn-info','formaction'=>Url::toRoute(['coursesgroup/copy'])]) ?>        
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'desc_name',
            [
                'attribute'=>'id_courses',
                'label'=>Yii::t('app','Курс'),
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($data){
                    return $data->getIdCoursesName();
                },
                'filter'=>CoursesGroup::getIdCoursesList(1),
            ],
            'price_hour',
            'desc_price_hour',
            'price_all',
            'desc_price_all',
            // 'data',
            // 'user_id',
			['class' => '\kartik\grid\CheckboxColumn'],
            ['class' => '\kartik\grid\ActionColumn'],
        ],
    ]); ?>
 <?= Html::endForm() ?>     
</div>
