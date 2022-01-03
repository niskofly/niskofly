<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Page */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$imageUrl = $model->getImageUrl();
$catalog_section = $model->getCatalogSection();
?>
<div class="page-view">

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
                'label' => Yii::t('app', 'Родительская страница'),
                'value' => $model->getParent()->one()->name
            ],
            [
                'label' => Yii::t('app', 'Язык'),
                'value' => $model->getLanguage()->one()->name
            ],
            'name',
            'alias',
            'before_content:html',
            [
                'label' => Yii::t('app', 'Картинка'),
                'value' => $imageUrl ?
                    "<img src='". $imageUrl ."' class='img-responsive'>":
                    Yii::t('app', 'Не установлена'),
                'format' => $imageUrl ? 'html' : 'text'
            ],
            'content:html',
            'aside:html',
            [
                'label' => Yii::t('app', 'Раздел каталога'),
                'value' => $catalog_section ?
                    $catalog_section['name'] :
                    Yii::t('app', 'Не установлен'),
            ],
            'after_content:html',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'created_at',
            'updated_at',
            'active',
        ],
    ]) ?>

</div>
