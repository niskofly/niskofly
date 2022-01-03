<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Language;

$actionUrl = "/";
$lang = Language::getCurrent();
if(isset($lang)){
    $actionUrl .= $lang->alias."/";
}
$actionUrl .= "feedback";

$this->title = Yii::t('app', 'Отправить заявку');
?>
<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin([
    'action' => $actionUrl,
]);?>
<?= $form->field($model, 'name'); ?>
<?= $form->field($model, 'phone'); ?>
<?= $form->field($model, 'promocode'); ?>

<?= $form->field($model, 'message')->TextArea(['rows' => 8]); ?>
<div class="form-group text-right">
    <?= Html::submitButton(Yii::t('app', 'Отправить'), [
        'class' => 'btn btn-default',
        'onclick' => 'ga(\'send\', \'event\', \'form\', \'call_back\', \''.$lang->alias.'_call_back_sent\');'
    ]) ?>
</div>
<?php ActiveForm::end(); ?>
