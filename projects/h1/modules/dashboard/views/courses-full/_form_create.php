<?php

use app\models\CoursesGroup;
use app\models\Language;
use app\models\Sched;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Courses;

/* @var $this yii\web\View */
/* @var $modelCourses app\models\Courses */
/* @var $form yii\widgets\ActiveForm */
/* @var $modelCoursesGroup_1 app\models\CoursesGroup */
/* @var $modelCoursesGroup_2 app\models\CoursesGroup */
/* @var $modelCoursesGroup_3 app\models\CoursesGroup */
/* @var $modelSched_1 app\models\Sched */
/* @var $modelSched_2 app\models\Sched */
/* @var $modelSched_3 app\models\Sched */

?>

<div class="courses-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelCourses, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelCourses, 'id_page')->dropdownList(
        Courses::getPageList(0), ['prompt' => 'Выбрать страницу привязки']
    ) ?>

    <?= $form->field($modelCourses, 'week')->textInput() ?>

    <?= $form->field($modelCourses, 'academic_hour')->textInput() ?>

    <?= $form->field($modelCourses, 'language_id')->dropdownList(
        Courses::getLanguageList(), ['prompt' => 'Выбрать язык']
    ) ?>

    <?= $form->field($modelCourses, 'user_id')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false) ?>


    <div class="form-group">
        <?= Html::submitButton($modelCourses->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $modelCourses->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>





</div>




