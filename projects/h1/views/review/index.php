<?php
/* @var $this yii\web\View */
/** @var $news \yii\db\ActiveRecord */


use yii\helpers\Url;
use app\widgets\CustomPagerWidget;


if(isset($_GET['page'])){
    $this->title = $page->meta_title.' '.Yii::t('app','стр.').' '.$_GET['page'];
}else{
    $this->title = $page->meta_title;
}

$this->registerMetaTag(['name' => 'description', 'content' => $page->meta_description .' '.Yii::t('app','стр.').' '.$_GET['page']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page->meta_keywords]);

//open graph
$this->registerMetaTag(['name' => 'og:title', 'content' => $page->meta_title]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $page->meta_description]);

$this->registerMetaTag(['name' => 'twitter:title', 'content' => $page->meta_title]);
$this->registerMetaTag(['name' => 'twitter:description', 'content' => $page->meta_description]);
//open graph


$this->params['breadcrumbs'] = $page->getPath();
?>
<div class="container">
<div class="row">
    <div class="col-md-8">
        <div class="border-page-header">
            <h1 class="pull-left"><?= Yii::t('app', 'Отзывы')?></h1>
            <div class="pull-right">
            <?= CustomPagerWidget::widget(['pagination' => $pages])?>
            </div>
        </div>
    </div>

</div>
<div class="narrow_row">
<div class="col-reviews-list">
<ul class="media-list reviews-list">
    <?php foreach($reviews as $review): ?>
        <li class="review">
            <?php $date = new DateTime($review->date); ?>
            <div class="review-date"><?=$date->format('j.m.Y')?></div>
            <h2><?=$review->name?></h2>
            <div class="review-rating" data-rating="<?=$review->rating?>"></div>
            <div class="reviews-list-text"><?=$review->text?></div>
            <a href="<?= Url::toRoute(['review/view', 'id' => $review->id]) ?>" class="btn btn-default"><?= Yii::t('app', 'читать далее') ?></a>
        </li>
    <?php endforeach ?>
</ul>
</div>
    <div class="col-reviews-form">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>

<div class="col-md-8">
    <hr class="p_media">
    <div class="pull-right">
        <?= CustomPagerWidget::widget(['pagination' => $pages])?>
    </div>
</div>
</div>