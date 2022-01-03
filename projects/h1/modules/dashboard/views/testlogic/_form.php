<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Test;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="logic-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'points_min')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'points_max')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'test_id')->dropDownList(
                ArrayHelper::map(
                    Test::find()->asArray()->all(),
                    'id', 'name'
                )
            ) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'ordering')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="ru">
                    <?php if (!$model->isNewRecord):?>
                        <div class="alert alert-info">
                        <p>Переменные шаблона:</p>
                        <strong>%Name%</strong> - Имя пользователя<br />
                        <strong>%Level%</strong> - Уровень знания языка<br />
                        </div>
                    <?php endif;?>
                    <?= $form->field($model, 'result')->widget(Widget::className(), [
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


    <?php if ($levelName): ?>

<?php
$level = $model->levelValue;
$min = ArrayHelper::map($level, 'level_name_id', 'points_minimum');
$max = ArrayHelper::map($level, 'level_name_id', 'points_maximum');
?>
    <div class="row">
        <div class="col-md-8">
            <h2>Количество баллов для достижения уровня</h2>
            <?php foreach ($levelName as $item): ?>
                <p style="margin-bottom: 20px;">
                    <label><?= $item->name ?></label><br/>
                    pointsMin <?= Html::input('text', 'TestLevel[' . $item->id . '][min]',
                        (array_key_exists($item->id, $min) ? $min[$item->id] : false),
                        array('style' => 'width:70px')); ?>
                    &nbsp;pointsMax <?= Html::input('text', 'TestLevel[' . $item->id . '][max]',
                        (array_key_exists($item->id, $min) ? $max[$item->id] : false),
                        array('style' => 'width:70px')); ?>
                </p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <p style="margin-top: 10px"></p>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
