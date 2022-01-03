<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Feedback */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$thumbUrl = $model->getThumbUrl();
$imageUrl = $model->getImageUrl();
?>
<div class="news-view">

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
            'date:date',
            [
                'label' => Yii::t('app', 'Картинка'),
                'value' => $thumbUrl ?
                    "<a href='".$imageUrl."' class='fancybox'><img src='".$thumbUrl."'></a>" :
                    Yii::t('app', 'Не установлена'),
                'format' => $thumbUrl ? 'html' : 'text'
            ],
            [
                'label' => Yii::t('app', 'Заголовок'),
                'value' => $model->getName()
            ],
            [
                'label' => Yii::t('app', 'Анонс'),
                'value' => $model->getAnnounce(true),
                'format' => 'html'
            ],
            [
                'label' => Yii::t('app', 'Текст'),
                'value' => $model->getText(),
                'format' => 'html'
            ],
        ],
    ]) ?>

</div>
