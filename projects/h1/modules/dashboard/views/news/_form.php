<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */


$thumbUrl = $model->getThumbUrl();
$imageUrl = $model->getImageUrl();
?>

<div class="news-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>
    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
                'dateFormat' => 'yyyy-MM-dd',
            ]) ?>
        </div>
        <div class="col-md-6">
            <?php if($thumbUrl && $imageUrl): ?>
                <a href="<?= $imageUrl ?>" class="fancybox">
            <?= Html::img($thumbUrl, ['class'=>'img-responsive']) ?>
                </a>
            <?= $form->field($model,'del_img')->checkBox() ?>
            <?php endif ?>
            <?= $form->field($model, 'image')->fileInput() ?>
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
                        <div class="col-md-12">
                            <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'announce_ru')->widget(Widget::className(), [
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
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'text_ru')->widget(Widget::className(), [
                                'settings' => [
                                    'lang' => 'ru',
                                    'minHeight' => 200,
                                    'buttonSource' => true,
                                    'plugins' => [
                                        'table',
                                        'clips',
                                        'fullscreen',
                                        'imagemanager',
                                        'filemanager'
                                    ],
                                    'formatting' => ['p', 'blockquote', 'h2'],
                                    'imageUpload' => Url::to(['/site/image-upload']),
                                    'imageManagerJson' => Url::to(['/site/images-get']),
                                    'fileManagerJson' => Url::to(['/site/files-get']),
                                    'fileUpload' => Url::to(['/site/file-upload'])
                                ]
                            ]) ?>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="en">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'announce_en')->widget(Widget::className(), [
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
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'text_en')->widget(Widget::className(), [
                                'settings' => [
                                    'lang' => 'ru',
                                    'minHeight' => 200,
                                    'buttonSource' => true,
                                    'plugins' => [
                                        'table',
                                        'clips',
                                        'fullscreen',
                                        'imagemanager',
                                        'filemanager'
                                    ],
                                    'formatting' => ['p', 'blockquote', 'h2'],
                                    'imageUpload' => Url::to(['/site/image-upload']),
                                    'imageManagerJson' => Url::to(['/site/images-get']),
                                    'fileManagerJson' => Url::to(['/site/files-get']),
                                    'fileUpload' => Url::to(['/site/file-upload'])
                                ]
                            ]) ?>
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
