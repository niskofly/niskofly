<?php

/* @var $this yii\web\View */
/* @var $pages */


$this->title = Yii::t('app', 'Поиск');
?>
<h1><?=$this->title?></h1>
<?php if($pages): ?>
    <ul class="media-list">
<?php foreach($pages as $k => $page): ?>
        <li class="media">
            <h4 class="media-heading"><a href="<?= $page->getAbsoluteUrl() ?>"><?= $page->name ?></a></h4>
            <article>
                <?= $page->getContentPreview() ?>
            </article>
        </li>
<?php endforeach ?>
    </ul>
<?php endif ?>
