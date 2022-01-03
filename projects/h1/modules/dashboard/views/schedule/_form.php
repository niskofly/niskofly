<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\CatalogSection;
use app\models\Service;

/* @var $this yii\web\View */
///* @var $model app\models\Schedule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catalog_service-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'section_id')->dropDownList(
                ArrayHelper::map(
                    Catalogsection::find()->asArray()->all(),
                    'id', 'name'
                )
            ) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'service_id')->dropDownList(
                ArrayHelper::map(
                    Service::find()->asArray()->all(),
                    'id', 'name_ru'
                )
            ) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'start_date_from')->widget(\yii\jui\DatePicker::classname(), [
                'dateFormat' => 'yyyy-MM-dd',
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'start_date_to')->widget(\yii\jui\DatePicker::classname(), [
                'dateFormat' => 'yyyy-MM-dd',
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#ru" aria-controls="home" role="tab" data-toggle="tab">Русский</a></li>
                <li role="presentation"><a href="#en" aria-controls="home" role="tab" data-toggle="tab">English</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="ru">
                    <?= $form->field($model, 'schedule_ru')->textarea(['maxlength' => true]) ?>
                </div>
                <div role="tabpanel" class="tab-pane" id="en">
                    <?= $form->field($model, 'schedule_en')->textarea(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'price')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
