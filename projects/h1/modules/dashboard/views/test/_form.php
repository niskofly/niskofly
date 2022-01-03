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
        <div class="col-md-2">

            <?= $form->field($model, 'ordering')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'language_id')->dropdownList(
                Language::find()->select(['name', 'id'])->indexBy('id')->column(), ['prompt' => 'Выбрать язык']
            ) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'active')->checkbox() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="ru">
                    <?= $form->field($model, 'description')->widget(Widget::className(), [
                        'settings' => [
                            'lang' => 'ru',
                            'minHeight' => 100,
                            'buttons' => [
                                'format',
                                'bold',
                                'italic',
                                'deleted',
                                'lists',
                                'link',
                            ],
                            'buttonSource' => true,
                            'plugins' => [
                                'clips',
                                'fullscreen',
                            ]
                        ]
                    ]) ?>
                </div>

            </div>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
