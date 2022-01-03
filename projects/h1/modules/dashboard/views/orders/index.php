<?php

use yii\helpers\Html;
//use yii\grid\GridView;
//use yii\grid\GridView;
use \kartik\grid\GridView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>
    	<?=Html::beginForm(Url::toRoute(['orders/copy']),'post') ?>    

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Orders'), ['create'], ['class' => 'btn btn-success']) ?>
         <?= Html::submitButton('Refresh', ['class' => 'btn btn-info','formaction'=>Url::toRoute(['orders/index'])]) ?>
        <?= Html::a(Yii::t('app', 'AMO synchronization orders'), ['synchronization'], ['class' => ' btn btn-warning']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return $model->getRowColor();
        },
        'columns' => [
            'id',
            [
                'attribute'=>'date',
                'format'=>['date', 'php:d.m.y']
            ],
            'firstname',
            'lastname',
            'course',
            [
                'attribute'=>'phone',
                'width'=>'130px',
            ],

            [
            'class' => 'kartik\grid\ActionColumn',
            'header'=>Yii::t('app','Email'),
            'template' => '{emails}',
            'buttons' => 
                [
                    'emails' => function ($url, $model) 
                    {
                        if ($model->paid==0)
                        {
//                            return Html::a($url, $url, 
                            return Html::a($model->email, Url::toRoute(['orders/emails','url'=>$model->url]), 
                                [   
                                    'class' => 'btn btn-success',
                                    'title' => Yii::t('app', 'send email'),
                                    'data-confirm'=> Yii::t('app','Отправить ссылку на оплату на '.$model->email.' ?'),
                                    ]
                            );
                        }
                        else
                        {
                            return Html::tag('p',$model->email);
                        }
                    }
                ],
            ],
            [
                'attribute'=>'price',
                'width'=>'80px',
            ],
//             'paid',
            // 'level',
            // 'start_date',
            // 'schedule',
            // 'course',
            // 'url:url',
            // 'id_schedule',
            [
                'attribute' => 'paid',
                'label'=>Yii::t('app','Paid'),
                'class' => '\kartik\grid\BooleanColumn',
                'trueLabel' => Yii::t('app','Оплачено'), 
                'falseLabel' => Yii::t('app','Нет оплаты'),
            ],
            'status',
            [
                'attribute'=>'date_status',
                'format'=>['date', 'php:d.m H:i']
            ],
            // 'user_id',

// 			['class' => '\kartik\grid\CheckboxColumn'],
            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{regenerate} {update} {delete}',
                'buttons' => 
                    [
                        'regenerate' => function ($url, $model) 
                        {
                            if ($model->paid==0)
                            {
                                return Html::a('<span class="glyphicon glyphicon-refresh"><span>', Url::to(['orders/regenerate-id','id'=>$model->id]), 
                                    [   
/*
                                        'class' => 'btn btn-success',
                                        'title' => Yii::t('app', 'send email'),
*/
                                        'data-confirm'=> Yii::t('app','Обновить номер заказа ?'),
                                    ]
                                );
                            }
                        }
                    ],
                
            ],
        ],
    ]); ?>

        <?= Html::endForm() ?> 

</div>
