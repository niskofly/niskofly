<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Courses;

/* @var $this yii\web\View */
/* @var $model app\models\Courses */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="courses-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_page')->dropdownList(
                    Courses::getPageList(0), ['prompt' => 'Выбрать страницу привязки']
                ) ?>



    <?= $form->field($model, 'week')->textInput() ?>

    <?= $form->field($model, 'academic_hour')->textInput() ?>

    <?= $form->field($model, 'language_id')->dropdownList(
                    Courses::getLanguageList(), ['prompt' => 'Выбрать язык']
                ) ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['value'=>Yii::$app->user->getId()])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
