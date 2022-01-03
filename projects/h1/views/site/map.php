<?php
/**
 * map.php - new.headin.pro
 * Initial version by: BeforyDeath
 * Initial version created on: 03.09.15 10:28
 */

use yii\widgets\Menu;

/** @var $menu array */

$this->title = Yii::t('app', 'Карта сайта');
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?= $this->title ?></h1>

<?= Menu::widget(['options' => ['class' => 'map'], 'items' => $menu]) ?>