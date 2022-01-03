<?php

/* @var $q */

use yii\helpers\Url;

?>

<form action="<?= Url::toRoute('search/search') ?>" method="get" class="form-search form-inline">
    <input type="text" class="search-query" placeholder="<?= Yii::t('app', 'Поиск') ?>" name="q" value="<?=$q?>">
</form>
