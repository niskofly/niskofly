<?php
/**
 * Created by PhpStorm.
 * User: scriptosaur
 * Date: 06.11.15
 * Time: 14:14
 */


/** @var $model \yii\db\ActiveRecord */
/** @var $article \app\models\News */

use yii\helpers\Url;

$date = new DateTime($article->date);

$title =  $article->getName().' Headway Institute FZ-LLC - '
    .Yii::t('app','Дата') .' '
    . $date->format('j.m.Y').
    ' - '.Yii::t('app','RUS');
$description = mb_strimwidth(strip_tags($article->getAnnounce()), 0,169);


$this->title = $title;
$this->registerMetaTag(['name' => 'description', 'content' => $description]);
$this->params['breadcrumbs'] = $path;

//open graph
$this->registerMetaTag(['name' => 'og:title', 'content' => $title]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $description]);

$this->registerMetaTag(['name' => 'twitter:title', 'content' => $title]);
$this->registerMetaTag(['name' => 'twitter:description', 'content' => $description]);
//open graph

$thumbUrl = $article->getThumbUrl();
$imageUrl = $article->getImageUrl();

?>


<div class="container">
<article class="news-detail">
    <div class="news-date"><?= $date->format('j.m.Y') ?></div>
    <h1><?= $article->getName() ?></h1>
<?php if($thumbUrl && $imageUrl): ?>
    <a href="<?= $imageUrl ?>" class="pull-left fancybox">
        <img src="<?= $thumbUrl ?>" class="news-image">
    </a>
<?php endif ?>
    <div class="news-detail-text"><?= $article->getText() ?></div>
    <a href="<?= Url::toRoute(['news/index']) ?>"><?=Yii::t('app', 'назад к списку')?></a>
</article>
</div>
