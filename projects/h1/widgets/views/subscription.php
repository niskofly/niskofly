<?php

/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Subscription;
use app\models\Language;
use himiklab\yii2\recaptcha\ReCaptcha;
use app\widgets\ReCaptchaInvisible;

$lang = Language::getCurrent();
?>

<?php $form = ActiveForm::begin([
    'action' => '/subscription',
    'options' => [
        'class' => 'subscription_form'
    ]
]);?>
    <h3><?= Yii::t('app', 'Подписка') ?></h3>
<div class="form-group">
    <?= Html::activeTextInput($model, 'name', ['placeholder' => Yii::t('app', 'Имя')]) ?>
</div>
<div class="form-group">
    <?= Html::activeTextInput($model, 'email', ['placeholder' => 'E-mail']) ?>
</div>
<div class="form-group">
    <?= Html::activeDropDownList($model, 'language', $model::getLanguageChoices(), [
        'placeholder' => Yii::t('app', 'Выбор языка'),
    ]) ?>
</div>
<div class="form-group"></div>

<?= $form->field($model, 'reCaptcha')->widget(
    ReCaptchaInvisible::className(),
    [
        'siteKey' => Yii::$app->params['reCaptcha']['siteKey'],
        'size' => ReCaptcha::SIZE_INVISIBLE,
    ]
)->label(false) ?>

<?= Html::submitButton(Yii::t('app', 'Подписаться'), [
    'class' => 'btn btn-primary',
    'onclick' => 'ga(\'send\', \'event\', \'form\', \'subscription\', \''.$lang->alias.'_subscription_sent\');'
]) ?>
<?php ActiveForm::end(); ?>
