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


<div class="row">

    <h1 style="text-align: center">Стоимость курсов</h1>
    <div class="courses-group-form">
        <div class="col-sm-4">
            <h2>Группа курса 1</h2>
            <?php $form = ActiveForm::begin(['id' => 'CoursesGroup_1']); ?>

            <?= $form->field($modelCoursesGroup_1, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCoursesGroup_1, 'desc_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCoursesGroup_1, 'id_courses')->dropdownList(
                CoursesGroup::getIdCoursesList(0), ['prompt' => 'Выберите курс ']
            ) ?>

            <?= $form->field($modelCoursesGroup_1, 'price_hour')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCoursesGroup_1, 'desc_price_hour')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCoursesGroup_1, 'price_all')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCoursesGroup_1, 'desc_price_all')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCoursesGroup_1, 'user_id')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false) ?>

            <div class="form-group">
                <?= Html::submitButton($modelCoursesGroup_1->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $modelCoursesGroup_1->isNewRecord ? 'btn btn-success' : 'btn btn-primary','name' => 'CoursesGroup_1']) ?>
            </div>


            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="courses-group-form">
        <div class="col-sm-4">
            <h2>Группа курса 2</h2>
            <?php $form = ActiveForm::begin(['id' => 'CoursesGroup_2']); ?>

            <?= $form->field($modelCoursesGroup_2, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCoursesGroup_2, 'desc_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCoursesGroup_2, 'id_courses')->dropdownList(
                CoursesGroup::getIdCoursesList(0), ['prompt' => 'Выберите курс ']
            ) ?>

            <?= $form->field($modelCoursesGroup_2, 'price_hour')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCoursesGroup_2, 'desc_price_hour')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCoursesGroup_2, 'price_all')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCoursesGroup_2, 'desc_price_all')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCoursesGroup_2, 'user_id')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false) ?>
            <div class="form-group">
                <?= Html::submitButton($modelCoursesGroup_2->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $modelCoursesGroup_2->isNewRecord ? 'btn btn-success' : 'btn btn-primary','name' => 'CoursesGroup_2']) ?>
            </div>


            <?php ActiveForm::end(); ?>
        </div>
    </div>


    <div class="courses-group-form">
        <div class="col-sm-4">
            <h2>Группа курса 3</h2>
            <?php $form = ActiveForm::begin(['id' => 'CoursesGroup_3']); ?>

            <?= $form->field($modelCoursesGroup_3, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCoursesGroup_3, 'desc_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCoursesGroup_3, 'id_courses')->dropdownList(
                CoursesGroup::getIdCoursesList(0), ['prompt' => 'Выберите курс ']
            ) ?>

            <?= $form->field($modelCoursesGroup_3, 'price_hour')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCoursesGroup_3, 'desc_price_hour')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCoursesGroup_3, 'price_all')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCoursesGroup_3, 'desc_price_all')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCoursesGroup_3, 'user_id')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false) ?>

            <div class="form-group">
                <?= Html::submitButton($modelCoursesGroup_3->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $modelCoursesGroup_3->isNewRecord ? 'btn btn-success' : 'btn btn-primary','name' => 'CoursesGroup_3']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

<div class="row">
    <h1 style="text-align: center">Рассписание групп</h1>

    <?
    $j=1;
    foreach ($modelsSched_1 as $i => $modelSched_1){ ?>

    <div class="sched-form">
        <div class="col-sm-4">
        <h2>Расписание группы курса 1 № <?= $j ?></h2>
        <?php $form = ActiveForm::begin(['id' => "Sched_1.".$i]); ?>

        <?= $form->field($modelSched_1, "[$i]schedule")->textInput(['maxlength' => true]) ?>

        <?= $form->field($modelSched_1, "[$i]id_courses_group")->dropdownList(
            Sched::getIdCoursesGroupList(0), ['prompt' => 'Выберите группу курса']
        ) ?>

        <?= $form->field($modelSched_1, "[$i]start_date")->widget(\yii\jui\DatePicker::classname(), [
            'language' => Language::getCurrent()->alias,
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>

        <?= $form->field($modelSched_1, "[$i]price_discount")->textInput() ?>

        <?= $form->field($modelSched_1, "[$i]archive")->textInput() ?>

        <?= $form->field($modelSched_1, "[$i]public")->checkbox() ?>

        <?= $form->field($modelSched_1, "[$i]dynamicPrice")->checkbox() ?>


        <?= $form->field($modelSched_1, "[$i]user_id")->hiddenInput(['value' => Yii::$app->user->getId()])->label(false) ?>
        <?= $form->field($modelSched_1, "[$i]id")->hiddenInput(['value' => $modelSched_1->id])->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton($modelSched_1->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $modelSched_1->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'name' => "Sched_1.".$i]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    </div>
    <? $j++;} ?>

</div>



<div class="row">
    <?  $j=1;
    foreach ($modelsSched_2 as $i => $modelSched_2){ ?>

            <div class="sched-form">
                <div class="col-sm-4">
                    <h2>Расписание группы курса 2  №<?= $j ?></h2>
                    <?php $form = ActiveForm::begin(['id' => "Sched_2.".$i]); ?>

                    <?= $form->field($modelSched_2, "[$i]schedule")->textInput(['maxlength' => true]) ?>

                    <?= $form->field($modelSched_2, "[$i]id_courses_group")->dropdownList(
                        Sched::getIdCoursesGroupList(0), ['prompt' => 'Выберите группу курса']
                    ) ?>

                    <?= $form->field($modelSched_2, "[$i]start_date")->widget(\yii\jui\DatePicker::classname(), [
                        'language' => Language::getCurrent()->alias,
                        'dateFormat' => 'yyyy-MM-dd',
                    ]) ?>

                    <?= $form->field($modelSched_2, "[$i]price_discount")->textInput() ?>

                    <?= $form->field($modelSched_2, "[$i]archive")->textInput() ?>

                    <?= $form->field($modelSched_2, "[$i]public")->checkbox() ?>

                    <?= $form->field($modelSched_2, "[$i]dynamicPrice")->checkbox() ?>


                    <?= $form->field($modelSched_2, "[$i]user_id")->hiddenInput(['value' => Yii::$app->user->getId()])->label(false) ?>

                    <div class="form-group">
                        <?= Html::submitButton($modelSched_2->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $modelSched_2->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'name' => "Sched_2.".$i]) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>

        </div>
    <? $j++; } ?>
</div>


<div class="row">
    <?
    $j=1;
    foreach ($modelsSched_3 as $i => $modelSched_3){ ?>

        <div class="sched-form">
            <div class="col-sm-4">
                <h2>Расписание группы  курса 3 №<?= $j ?></h2>
                <?php $form = ActiveForm::begin(['id' => "Sched_3.".$i]); ?>

                <?= $form->field($modelSched_3, "[$i]schedule")->textInput(['id' => "Sched_3.".$i . '-schedule','maxlength' => true]) ?>

                <?= $form->field($modelSched_3, "[$i]id_courses_group")->dropdownList(
                    Sched::getIdCoursesGroupList(0), ['prompt' => 'Выберите группу курса']
                ) ?>

                <?= $form->field($modelSched_3, "[$i]start_date")->widget(\yii\jui\DatePicker::classname(), [
                    'language' => Language::getCurrent()->alias,
                    'dateFormat' => 'yyyy-MM-dd',
                ]) ?>

                <?= $form->field($modelSched_3, "[$i]price_discount")->textInput() ?>

                <?= $form->field($modelSched_3, "[$i]archive")->textInput() ?>

                <?= $form->field($modelSched_3, "[$i]public")->checkbox() ?>

                <?= $form->field($modelSched_3, "[$i]dynamicPrice")->checkbox() ?>


                <?= $form->field($modelSched_3, "[$i]user_id")->hiddenInput(['value' => Yii::$app->user->getId()])->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton($modelSched_3->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $modelSched_3->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'name' => "Sched_3.".$i]) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

        </div>
    <? $j++;} ?>
</div>


</div>




