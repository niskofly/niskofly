<?php
/**
 * Created by PhpStorm.
 * User: scriptosaur
 * Date: 06.11.15
 * Time: 13:40
 */


use yii\helpers\Url;
use app\widgets\CustomPagerWidget;


/** @var $news \yii\db\ActiveRecord */


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
<div class="col-md-12">
<div class="border-page-header">
    <h1 class="pull-left"><?= Yii::t('app', 'Новости') ?></h1>
    <div class="pull-right">
        <?= CustomPagerWidget::widget(['pagination' => $pages]) ?>
    </div>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12">
<ul class="media-list news_list index_content_list">
<?php foreach($news as $article): ?>
    <li class="media news_item index_content_list_item">
        <div class="media-left">
<?php
$thumbUrl = $article->getThumbUrl();
$imageUrl = $article->getImageUrl();
?>
<?php if($thumbUrl && $imageUrl): ?>
            <a href="<?= $imageUrl ?>" class="fancybox">
                <img src="<?= $thumbUrl ?>" class="media-object">
            </a>
<?php endif ?>
        </div>
        <div class="media-body">
            <?php $date = new DateTime($article->date); ?>
            <div class="news-date"><?= $date->format('j.m.Y') ?></div>
            <h2 class="media-heading"><?= $article->getName() ?></h2>
            <div class="news-text"><?= $article->getAnnounce() ?></div>
            <a href="<?= Url::toRoute(['news/view', 'id' => $article->id]) ?>" class="btn btn-default"><?= Yii::t('app', 'читать далее') ?></a>
        </div>
    </li>
<?php endforeach ?>
</ul>
</div>

<div class="col-md-12">
    <hr class="p_media">
    <div class="pull-right">
        <?= CustomPagerWidget::widget(['pagination' => $pages]) ?>
    </div>
</div>

</div>
</div>
