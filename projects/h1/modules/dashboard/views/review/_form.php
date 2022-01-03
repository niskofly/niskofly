<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Review;
use app\models\Language;

/* @var $this yii\web\View */
/* @var $model app\models\Review */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="review-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
		<?= $form->field($model, 'pages')->dropDownList(Review::getPagesList(),['size' => '10','multiple'=>'multiple','prompt' => Yii::t('app','Выберите страницу на которой будет отображаться отзыв')]) ?>
        </div>

        <div class="col-md-6">
		<?= $form->field($model, 'language_id')->dropDownList(Review::getLanguageList(),['prompt' => Yii::t('app','Язык')]) ?>
        </div>
    </div>
    
    
    <div class="row">
	    
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'rating')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'text')->textArea(['rows' => 8]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
    'language' => Language::getCurrent()->alias,
    'dateFormat' => 'yyyy-MM-dd',
]) ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
