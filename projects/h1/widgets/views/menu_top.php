<?php
/**
 * menu_top.php - new.headin.pro
 * Initial version by: BeforyDeath
 * Initial version created on: 28.08.15 10:29
 */
use yii\bootstrap\Nav;

/** @var $result array */
?>
<?php
echo Nav::widget([
    'options' => ['class' => 'nav-justified'],
    'items' => $result,
//    'activateParents'=>true,
]);
$this->registerJs('$(".navbar [data-toggle=dropdown]").click(function(){window.location=$(this).attr("href")})');
?>
