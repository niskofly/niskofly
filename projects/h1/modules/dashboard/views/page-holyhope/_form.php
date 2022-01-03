<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PageHolyhope */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-holyhope-form">

    <?php $form = ActiveForm::begin(); ?>


    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'page_ids')->dropDownList(\app\models\PageHolyhope::getPagesList(), ['size' => '20', 'multiple' => 'multiple', 'prompt' => Yii::t('app', 'Выберите страницу на которой будет отображаться отзыв')]) ?>
        </div>

       <div class="col-md-6">
            <?= $form->field($model, 'holyhope_ids')->dropDownList(\app\models\PageHolyhope::getHolyhopeList(), ['size' => '20', 'multiple' => 'multiple', 'prompt' => Yii::t('app', 'Язык')]) ?>
       </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
