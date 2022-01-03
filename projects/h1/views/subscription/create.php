<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Subscription;


$this->title = Yii::t('app', 'Подписка');
?>
<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin();?>
<?= $form->field($model, 'name'); ?>
<?= $form->field($model, 'email'); ?>
<?= $form->field($model, 'language')->dropdownList($model::getLanguageChoices()); ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Подписаться'), ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
