<?php

/* @var $this yii\web\View */

use himiklab\yii2\recaptcha\ReCaptcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = Yii::t('app', 'Отправить заявку');
?>
<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin();?>
<div class="row">
    <div class="col-md-5"><?= $form->field($model, 'name'); ?></div>
    <div class="col-md-5"><?= $form->field($model, 'phone'); ?></div>
</div>
<div class="row">
    <div class="col-md-5"><?= $form->field($model, 'email'); ?></div>
    <div class="col-md-5"><?= $form->field($model, 'course')->dropdownList($model::getCourseChoices()); ?></div>
</div>
<div class="row">
    <div class="col-md-5"><?= $form->field($model, 'promocode'); ?></div>
</div>
<?= $form->field($model, 'message')->TextArea(['rows' => 8]); ?>
<div class="form-group text-right">
    <?= Html::submitButton(Yii::t('app', 'Отправить'), [
        'class' => 'btn btn-default'
    ]) ?>
</div>

<?= $form->field($model, 'reCaptcha')->widget(
    ReCaptcha::className(),
    [
        'siteKey' => Yii::$app->params['reCaptcha']['siteKey'],
        'size' => ReCaptcha::SIZE_INVISIBLE,
    ]
)->label('') ?>

<?php ActiveForm::end(); ?>
