<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CoursesGroup;
/* @var $this yii\web\View */
/* @var $model app\models\CoursesGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="courses-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_courses')->dropdownList(
                    CoursesGroup::getIdCoursesList(0), ['prompt' => 'Выберите курс ']
                ) ?>


    <?= $form->field($model, 'price_hour')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc_price_hour')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_all')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc_price_all')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['value'=>Yii::$app->user->getId()])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
