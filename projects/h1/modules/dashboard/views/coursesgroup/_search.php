<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CoursesGroupSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="courses-group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'desc_name') ?>

    <?= $form->field($model, 'id_courses') ?>

    <?= $form->field($model, 'price_hour') ?>

    <?php // echo $form->field($model, 'desc_price_hour') ?>

    <?php // echo $form->field($model, 'price_all') ?>

    <?php // echo $form->field($model, 'desc_price_all') ?>

    <?php // echo $form->field($model, 'data') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
