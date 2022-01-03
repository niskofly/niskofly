<?php

/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Language;
use himiklab\yii2\recaptcha\ReCaptcha;
use app\widgets\ReCaptchaInvisible;

$lang = Language::getCurrent();

?>
<h3><?= Yii::t('app', 'Отправить заявку') ?></h3>

<?php $form = ActiveForm::begin([
    'action' => "/{$lang->alias}/feedback",
]);?>
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
		<?php  
			isset($_COOKIE['roistat_visit']) ? $roistat=$_COOKIE['roistat_visit'] : $roistat='';	
			isset($_COOKIE['_ga']) ? $google=$_COOKIE['_ga'] : $google='';	
		?>

        <?= $form->field($model, 'google')->hiddenInput([
            'value'=> $google
        ])->label(false); ?>

        <?= $form->field($model, 'roistat')->hiddenInput([
            'value'=> $roistat
        ])->label(false); ?>

<?= $form->field($model, 'reCaptcha')->widget(
    ReCaptchaInvisible::className(),
    [
        'siteKey' => Yii::$app->params['reCaptcha']['siteKey'],
        'size' => ReCaptcha::SIZE_INVISIBLE,
    ]
)->label(false) ?>

<div class="form-group text-right">
    <?= Html::submitButton(Yii::t('app', 'Отправить'), [
        'class' => 'btn btn-default',
        'onclick' => 'ga(\'send\', \'event\', \'form\', \'main_form\', \''.$lang->alias.'_main_form_sent\');'
    ]) ?>
</div>
<?php ActiveForm::end(); ?>
