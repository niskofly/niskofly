<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\models\TestAnswer;
use app\models\TestQuestion;

/* @var $this yii\web\View */
/* @var $model app\models\TestQuestion */

$this->title = 'Test Answer:';
$this->params['breadcrumbs'][] = ['label' => 'TestAnswer', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-view">

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
            'testquestion_id',
            'name',
            'points',
            'active',
            'ordering'
        ],
    ]) ?>



</div>
