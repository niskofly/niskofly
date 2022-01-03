<?php

/* @var $reviews */

use yii\helpers\Url;

?>

<?php if(count($reviews) > 0): ?>
<div class="index-reviews-widget index_content_list">
    <div class="page-header clearfix">
        <h2 class="pull-left rew"><?= Yii::t('app', 'Отзывы') ?></h2>
        <a class="pull-right" href="<?= Url::toRoute(['review/index']) ?>"><?= Yii::t('app', 'Смотреть все') ?></a>
    </div>
    <ul class="reviews-list">
        <?php foreach($reviews as $review):?>
            <li class="review">
                <?php $date = new DateTime($review->date); ?>
                <div class="review-date"><?=$date->format('j.m.Y')?></div>
                <h3><?= $review->name ?></h3>
                <div class="review-rating" data-rating="<?= $review->rating ?>"></div>
                <div class="review-text"><?= $review->getAnnounce() ?></div>
                <a href="<?= Url::toRoute(['review/view', 'id' => $review->id]) ?>" class="btn btn-default"><?= Yii::t('app', 'читать далее') ?></a>
            </li>
        <?php endforeach ?>
    </ul>
</div>
<?php endif ?>
