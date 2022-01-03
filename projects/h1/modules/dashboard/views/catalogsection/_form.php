<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CatalogSection */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catalog_section-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
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
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'title_price_ru')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="en">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'title_en')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'title_price_en')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
