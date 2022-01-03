<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\models\TestQuestion;
use app\models\Test;

/* @var $this yii\web\View */
/* @var $model app\models\TestQuestion */

$this->title = 'TestQuestion:';
$this->params['breadcrumbs'][] = ['label' => 'Test', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => Yii::t('app', 'Тест'),
                'value' => '<a href="' . Url::toRoute(['/dashboard/tests/view', 'id' => $model->test_id]) . '">' .Test::findOne($model->test_id)->name . '</a>',
                'format' => 'html'
            ],
            'name',
            'active',
            'ordering'
        ],
    ]) ?>

</div>
