<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Language;

$lang = Language::getCurrent();


?>
<div class="review_form">
<?php $form = ActiveForm::begin([
    'action' => '/review/create',
]);?>
<h3><?=Yii::t('app', 'Оставить отзыв')?></h3>
<div class="review_form__rating" id="add-rating"></div>
<?= Html::activeHiddenInput($model, 'rating') ?>

<?= Html::activeHiddenInput($model, 'language_id',['value'=>$lang->id]) ?>

<?= Html::activeTextInput($model, 'name', [
    'class' => 'form-control',
    'placeholder' => Yii::t('app', 'Имя')
]) ?>
<?= Html::activeTextarea($model, 'text', [
    'class' => 'form-control',
    'placeholder' => Yii::t('app', 'Сообщение'),
    'rows' => 8
]) ?>
<?= Html::submitButton(Yii::t('app', 'Оставить отзыв'), [
    'class' => 'btn btn-default center-block'
]) ?>
<?php ActiveForm::end(); ?>
</div>
