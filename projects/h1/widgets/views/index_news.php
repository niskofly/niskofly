<?php

/* @var $news */

use yii\helpers\Url;

?>

<?php if(count($news) > 0): ?>
<div class="index-news-widget index_content_list">
    <div class="page-header clearfix">
        <h2 class="pull-left"><?= Yii::t('app', 'Новости') ?></h2>
        <a class="pull-right" href="<?= Url::toRoute(['news/index']) ?>"><?= Yii::t('app', 'Смотреть все') ?></a>
    </div>
    <ul class="media-list news_list">
<?php foreach($news as $article):?>
        <li class="media">
<?php
$thumbUrl = $article->getThumbUrl();
$imageUrl = $article->getImageUrl();
?>
<?php if($thumbUrl && $imageUrl): ?>
            <a href="<?= $imageUrl ?>" class="media-left fancybox">
                <img src="<?= $thumbUrl ?>" class="media-object" alt="<?= $article->getName() ?>">
            </a>
<?php endif ?>
            <br class="clearfix visible-xs-block">
            <div class="media-body">
                <?php $date = new DateTime($article->date); ?>
                <div class="news-date"><?= $date->format('j.m.Y') ?></div>
                <h3 class="media-heading"><?= $article->getName() ?></h3>
                <div class="news-text"><?= $article->getAnnounce() ?></div>
                <a href="<?= Url::toRoute(['news/view', 'id' => $article->id]) ?>" class="btn btn-default"><?= Yii::t('app', 'читать далее') ?></a>
            </div>
        </li>
<?php endforeach ?>
    </ul>
</div>
<?php endif ?>
