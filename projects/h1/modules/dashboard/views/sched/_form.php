<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Sched;
use app\models\Language;

/* @var $this yii\web\View */
/* @var $model app\models\Sched */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sched-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'schedule')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_courses_group')->dropdownList(
                    Sched::getIdCoursesGroupList(0), ['prompt' => 'Выберите группу курса']
                ) ?>

    <?= $form->field($model, 'start_date')->widget(\yii\jui\DatePicker::classname(), [
    'language' => Language::getCurrent()->alias,
    'dateFormat' => 'yyyy-MM-dd',
	]) ?>    
    
    <?= $form->field($model, 'price_discount')->textInput() ?>

    <?= $form->field($model, 'archive')->textInput() ?>

    <?= $form->field($model, 'public')->checkbox() ?>

    <?= $form->field($model, 'dynamicPrice')->checkbox() ?>


    <?= $form->field($model, 'user_id')->hiddenInput(['value'=>Yii::$app->user->getId()])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
