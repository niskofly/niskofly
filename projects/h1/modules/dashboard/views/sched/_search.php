<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SchedSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sched-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'schedule') ?>

    <?= $form->field($model, 'id_courses_group') ?>

    <?= $form->field($model, 'start_date') ?>

    <?= $form->field($model, 'archive') ?>

    <?php // echo $form->field($model, 'public') ?>

    <?php // echo $form->field($model, 'data') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
