<?php

/* @var $this yii\web\View */
use app\models\Language;
use yii\helpers\Html;
use yii\helpers\Url;

$homeUrl = "/";
$lang = Language::getCurrent();
if(isset($lang->alias)){
    $homeUrl .= $lang->alias;
}
Yii::$app->homeUrl = $homeUrl;


?>


<div class="container">
    <h1> <?= Yii::t('app','Что-то при оплате пошло не так !') ?> </h1>
    <br>
    <br>
    <?= Yii::t('app','Вот сообщение банка :') ?> 
    <br>
    <?= Yii::t('app','Код ответа :') ?> <?= $error['response_code'] ?> 
    <br>
    
    <?= Yii::t('app','Сообщение :') ?> <?= $error['response_message'] ?>
    <br>
    <?= Yii::t('app','Статус :') ?> <?= $error['status'] ?>
    <br>

    <h4> <?= Yii::t('app','Передайте этот ответ администрации сайта и мы решим Вашу проблему') ?> </h4>
    
</div>