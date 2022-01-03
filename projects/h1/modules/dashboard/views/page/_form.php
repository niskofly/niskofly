<?php

use app\models\Language;
use app\models\Page;
use app\models\CatalogSection;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form yii\widgets\ActiveForm */


$imageUrl = $model->getImageUrl();
?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype'=>'multipart/form-data']
]); ?>

<?= $form->errorSummary($model); ?>
<div class="row">
    <div class="col-lg-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
        
    </div>
    <div class="col-lg-6">
        <div class="row">
            <div class="col-lg-6">
                <?= $form->field($model, 'language_id')->dropdownList(
                    Language::find()->select(['name', 'id'])->indexBy('id')->column(), ['prompt' => 'Выбрать язык']
                ) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'active')->dropdownList([1 => 'yes', 2 => 'no']) ?>
            </div>
        </div>
        <?php
        $page = Page::find()->select(['id', 'parent_id', 'name', 'alias'])->asArray()->all();
        $page = Page::TreeArray($page);
        $page = Page::selected($page);
        ?>

        <?= $form->field($model, 'parent_id')->dropdownList(
            $page, ['prompt' => 'В корне']
        ) ?>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <?php if($imageUrl): ?>
            <?= Html::img($imageUrl, ['class'=>'img-responsive']) ?>
            <?= $form->field($model,'del_img')->checkBox() ?>
        <?php endif ?>
        <?= $form->field($model, 'image')->fileInput() ?>
    </div>
</div>


<div class="row">
    <div class="col-xs-12">
        <?= $form->field($model, 'h1')->widget(Widget::className(), [
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 100,
                'buttonSource' => true,
                'plugins' => [
                    'table',
                    'clips',
                    'fullscreen',
                    'imagemanager',
                ],
                'formatting' => ['blockquote', 'h2'],
                'imageUpload' => Url::to(['/site/image-upload']),
                'imageManagerJson' => Url::to(['/site/images-get']),
                'fileManagerJson' => Url::to(['/site/files-get']),
                'fileUpload' => Url::to(['/site/file-upload'])
            ]
        ]) ?>
    </div>
</div>



<div class="row">
    <div class="col-xs-12">
        <?= $form->field($model, 'before_content')->widget(Widget::className(), [
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 100,
                'buttonSource' => true,
                'plugins' => [
                    'table',
                    'clips',
                    'fullscreen',
                    'imagemanager',
                ],
                'formatting' => ['blockquote', 'h2'],
                'imageUpload' => Url::to(['/site/image-upload']),
                'imageManagerJson' => Url::to(['/site/images-get']),
                'fileManagerJson' => Url::to(['/site/files-get']),
                'fileUpload' => Url::to(['/site/file-upload'])
            ]
        ]) ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-9">
<?= $form->field($model, 'content')->widget(Widget::className(), [
    'settings' => [
        'lang' => 'ru',
        'minHeight' => 200,
/*
       'buttons' => [
           'format',
           'bold',
           'italic',
           'deleted',
           'lists',
           'image',
           'file',
           'link',
           'horizontalrule'
 
      ],
*/
        'buttonSource' => true,
        'plugins' => [
            'table',
            'clips',
            'fullscreen',
            'imagemanager',
        ],
        'formatting' => ['p', 'blockquote', 'h2'],
        'imageUpload' => Url::to(['/site/image-upload']),
        'imageManagerJson' => Url::to(['/site/images-get']),
        'fileManagerJson' => Url::to(['/site/files-get']),
        'fileUpload' => Url::to(['/site/file-upload'])
    ]
]) ?>
    </div>
    <div class="col-lg-3">
        <?= $form->field($model, 'aside')->TextArea(['rows' => 30]) ?>
    </div>
</div>

<div class="row">
  

    <div class="col-xs-12">
        <?= $form->field($model, 'after_content')->widget(Widget::className(), [
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 100,
                'buttonSource' => true,
                'plugins' => [
                    'table',
                    'clips',
                    'fullscreen',
                    'imagemanager',
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

<div class="row">
	
	<div class="col-xs-4">
	<?= $form->field($model, 'block2_1_head')->textInput() ?>
	</div>
	<div class="col-xs-4">
	<?= $form->field($model, 'block2_2_head')->textInput() ?>
	</div>
	<div class="col-xs-4">
	<?= $form->field($model, 'block2_3_head')->textInput() ?>
	</div>
	<div class="col-xs-4">
	<?= $form->field($model, 'block2_1_desc')->textArea(['rows'=>10]) ?>
	</div>
	<div class="col-xs-4">
	<?= $form->field($model, 'block2_2_desc')->textArea(['rows'=>10]) ?>
	</div>
	<div class="col-xs-4">
	<?= $form->field($model, 'block2_3_desc')->textArea(['rows'=>10]) ?>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<?= $form->field($model, 'block3_head')->textArea(['rows' => 2]) ?>
	</div>
</div>
<div class="row">
	<div class="col-xs-6">
			<?= $form->field($model, 'block4_1_head')->textInput() ?>
	</div>
	<div class="col-xs-6">
			<?= $form->field($model, 'block4_2_head')->textInput() ?>
	</div>
	<div class="col-xs-6">
			<?= $form->field($model, 'block4_1_desc')->widget(Widget::className(), [
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 200,
                'buttonSource' => true,
                'plugins' => [
                    'table',
                    'clips',
                    'fullscreen',
                ],
                'formatting' => ['p', 'blockquote', 'h2'],
            ]
        ]) ?>

	</div>
	<div class="col-xs-6">
			<?= $form->field($model, 'block4_2_desc')->widget(Widget::className(), [
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 200,
                'buttonSource' => true,
                'plugins' => [
                    'table',
                    'clips',
                    'fullscreen',
                ],
                'formatting' => ['p', 'blockquote', 'h2'],
            ]
        ]) ?>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<?= $form->field($model, 'hrefs')->widget(Widget::className(), [
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 200,
                'buttonSource' => true,
                'plugins' => [
                    'table',
                    'clips',
                    'fullscreen',
                ],
                'formatting' => ['p', 'blockquote', 'h2'],
            ]
        ]) ?>
	</div>
</div>



<?= $form->field($model, 'show_feedback_form')->checkbox() ?>

<?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'sort')->textInput(['maxlength' => true,'type' => 'number']) ?>

<?php /*<?= $form->field($model, 'active')->checkboxList([1 => 'yes']) ?>*/ ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
