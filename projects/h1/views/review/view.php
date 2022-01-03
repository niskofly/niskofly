<?php
/**
 * Created by PhpStorm.
 * User: scriptosaur
 * Date: 06.11.15
 * Time: 14:14
 */


/** @var $model \yii\db\ActiveRecord */
/** @var $review \app\models\Review */

use yii\helpers\Url;

$date = new DateTime($review->date);


$title = Yii::t('app','Отзыв') .' - '. $review->name.' - '
    . Yii::t('app','Дата') . ' '
    . $date->format('j.m.Y') .' - '.Yii::t('app','RUS');
$description = Yii::t('app','Отзыв_слово').' - '.mb_strimwidth(strip_tags($review->text), 0,159);

$this->title = $title;

$this->registerMetaTag(['name' => 'description', 'content' => $description]);

//open graph
$this->registerMetaTag(['name' => 'og:title', 'content' => $title]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $description]);

$this->registerMetaTag(['name' => 'twitter:title', 'content' => $title]);
$this->registerMetaTag(['name' => 'twitter:description', 'content' => $description]);
//open graph


$this->params['breadcrumbs'] = $path;
?>


<div class="container">
<article class="review-detail">
    <?php $date = new DateTime($review->date); ?>
    <div class="review-date"><?=$date->format('j.m.Y')?></div>
    <h1><?= $review->name ?></h1>
    <div class="review-rating" data-rating="<?=$review->rating?>"></div>
    <div class="review-detail-text"><?=$review->text?></div>
    <a href="<?= Url::toRoute(['review/index', 'id' => $review->id]) ?>" ><?= Yii::t('app', 'назад к списку') ?></a>
</article>
</div>
