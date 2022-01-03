<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Test;
use app\models\Language;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="test-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'name_tech')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    </div>


<?= $form->field($model, 'test_id')->dropDownList(
    ArrayHelper::map(
        Test::find()->all(),
        'id', 'name'
    )
) ?>

<?= $form->field($model, 'language_id')->dropDownList(
    ArrayHelper::map(
        Language::find()->all(),
        'id', 'name'
    )
) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
