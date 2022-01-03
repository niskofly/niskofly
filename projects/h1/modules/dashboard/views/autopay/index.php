<?php

use yii\helpers\Html;
use yii\helpers\Url;
use \kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AutopaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Autopays');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="autopay-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	<?=Html::beginForm(Url::to(['autopay/copy']),'post') ?>    

    <p>
        <?= Html::a(Yii::t('app', 'Create Autopay'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Generate auto payment orders'), ['recurring-transactions'], ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton('Copy  selected row ', ['class' => 'btn btn-info','formaction'=>Url::toRoute(['autopay/copy'])]) ?>        
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'id',
                'width'=>'30px',
            ],
            [
                'attribute'=>'date',
                'format'=>['date', 'php:d.m.Y']
            ],
            'firstname',
            'lastname',
            'phone',
            'email:email',
            'summaAutopay',
            'summaPaid',

            // 'course',
            // 'user_id',
			['class' => 'yii\grid\CheckboxColumn'],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
            ],
        ],
    ]); ?>
 <?= Html::endForm() ?>      
</div>
