<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LandingSlider */
/* @var $form yii\widgets\ActiveForm */

$thumbUrl = $model->getThumbUrl();
$imageUrl = $model->getImageUrl();
?>

<div class="landing-slider-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
        ]
    ); ?>

     <div class="col-md-12">
        <?php if($thumbUrl && $imageUrl): ?>
            <a href="<?= $imageUrl ?>" class="fancybox">
                <?= Html::img($thumbUrl, ['class'=>'img-responsive']) ?>
            </a>
            <?= $form->field($model,'del_img')->checkBox() ?>
        <?php endif ?>
        <?= $form->field($model, 'image')->fileInput() ?>
    </div>

    <?= $form->field($model, 'href')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput(['type' => 'number']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
