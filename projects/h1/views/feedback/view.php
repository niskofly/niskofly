<?php

/* @var $this yii\web\View */
use app\models\Language;

$homeUrl = "/";
$lang = Language::getCurrent();
if(isset($lang->alias)){
    $homeUrl .= $lang->alias;
}
Yii::$app->homeUrl = $homeUrl;


$this->title = 'Feedback';

?>
<div class="container">
<h1><?=Yii::t('app', 'Благодарим Вас за интерес проявленный к нашему центру.')?></h1>
<p><?=Yii::t('app', 'Ваш персональный менеджер свяжется с Вами в течение 24 часов.')?></p>
</div>
