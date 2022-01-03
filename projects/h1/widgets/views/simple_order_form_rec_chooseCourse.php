<?php

/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Language;
use himiklab\yii2\recaptcha\ReCaptcha;
use app\widgets\ReCaptchaInvisible;

$lang = Language::getCurrent();

?>

  <div class="modal_join"><img src="/images/page/plus.svg" width="63">
    <h2 class="modal_join_head"><?= Yii::t('app', 'Регистрация на курс'); ?></h2>

    <div><?= Yii::t('app', 'Благодарим Вас за проявленный интерес. Заполните форму или'); ?>
        <a href="tel:+<?=Yii::$app->params['adminPhone']?>" class="form_join_call"><?= Yii::t('app', 'позвоните нам'); ?></a>
    </div>

    <div class="form_join_wrap w-form">
        <?php $form = ActiveForm::begin([
            'action' => "/{$lang->alias}/feedback",
        ]); ?>

        <?= $form->field($model, 'name')->textInput([
            'class' => 'callback form_join_field w-input',
            'placeholder' => Yii::t('app', 'Введите имя'),
        ])->label(false); ?>
        <?= $form->field($model, 'phone')->textInput([
            'class' => 'callback form_join_field w-input',
            'placeholder' => Yii::t('app', 'Введите телефон'),
        ])->label(false); ?>

        <?= $form->field($model, 'email')->textInput([
            'class' => 'callback form_join_field w-input',
            'placeholder' => Yii::t('app', 'Введите e-mail'),
        ])->label(false); ?>
        <?= $form->field($model, 'message')->textInput([
            'class' => 'callback form_join_field w-input',
            'placeholder' => Yii::t('app', 'Сообщение'),
        ])->label(false); ?>
        <?= $form->field($model, 'promocode')->textInput([
            'class' => 'callback form_join_field w-input',
            'placeholder' => Yii::t('app', 'Промокод'),
        ])->label(false); ?>
        <?= $form->field($model, 'course')->hiddenInput([
            'value'=> $selectedCourse
        ])->label(false); ?>

		<?php  
			isset($_COOKIE['roistat_visit']) ? $roistat=$_COOKIE['roistat_visit'] : $roistat='';	
			isset($_COOKIE['_ga']) ? $google=$_COOKIE['_ga'] : $google='';	
		?>

        <?= $form->field($model, 'google')->hiddenInput([
            'value'=> $google
        ])->label(false); ?>

        <?= $form->field($model, 'roistat')->hiddenInput([
            'value'=> $roistat
        ])->label(false); ?>
        
        <?= $form->field($model, 'pay')->hiddenInput([
            'value'=> 0,'id' => 'needPay'
        ])->label(false); ?>

        <?= $form->field($model, 'price')->hiddenInput([
            'value'=> 100, 'id' => 'priceJoin'
        ])->label(false); ?>

        <?= $form->field($model, 'id_schedule')->hiddenInput([
            'value'=> 0, 'id' => 'idSchedule' 
        ])->label(false); ?>




        <?= $form->field($model, 'reCaptcha')->widget(
            ReCaptchaInvisible::className(),
            [
                'siteKey' => Yii::$app->params['reCaptcha']['siteKey'],
                'size' => ReCaptcha::SIZE_INVISIBLE,
            ]
        )->label(false) ?>


        <?= $form->field($model, 'group')->hiddenInput([
            'value'=> '','id' => 'group'
        ])->label(false); ?>

        <div class="form-group text-right">
            <?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'button joinform sendrequest w-button','onclick'=>'ga(\'send\', \'event\', \'form\', \'join_cource\', \'join_course_sent\');return true;']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="close_form" data-ix="close-form-join"><span class="close_icon">M</span> close form</div>
</div>


