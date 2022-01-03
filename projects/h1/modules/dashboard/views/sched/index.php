<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use \kartik\grid\GridView;
use app\models\Sched;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SchedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Scheds');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sched-index">

    <h1><?= Html::encode($this->title) ?></h1>
	<?=Html::beginForm(Url::toRoute(['sched/copy']),'post') ?>    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Sched'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton('Copy selected row ', ['class' => 'btn btn-info','formaction'=>Url::toRoute(['sched/copy'])]) ?>

    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'schedule',
            [
                'label'=>Yii::t('app','Язык'),
                'format'=>'text',
                'content'=>function($data)
                {
                    return $data->getLang();
                }
            ],
            [
                'attribute'=>'id_courses_group',
                'label'=>Yii::t('app',' Группа курса'),
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($data){
                    return $data->getIdCoursesGroupName();
                },
                'filter'=>Sched::getIdCoursesGroupList(1),
            ],
//            'id_courses_group',
            'start_date',
            'archive',
            [ 
            	'attribute'=>'price_discount',
            	'label'=>Yii::t('app','Цена со скидкой')
            ],
            [
                'attribute' => 'dynamicPrice',
                'label' => Yii::t('app','Дин. прайс'),
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($data){
                    return ($data->dynamicPrice==1) ? Yii::t('app','yes') : Yii::t('app','no');
                },
            ],
            // 'data',
            // 'user_id',
			['class' => '\kartik\grid\CheckboxColumn'],
            ['class' => '\kartik\grid\ActionColumn'],
        ],
    ]); ?>
    <?= Html::endForm() ?> 
</div>
