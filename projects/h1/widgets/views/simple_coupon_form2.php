<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Language;
use himiklab\yii2\recaptcha\ReCaptcha;
use app\widgets\ReCaptchaInvisible;

$actionUrl = "/";
$lang = Language::getCurrent();
if (isset($lang)) {
    $actionUrl .= $lang->alias . "/";
}
$actionUrl .= "feedback";
$lang = Language::getCurrent();

?>
<div class="modal_join modal_voucher"><img src="/images/page/voucher.svg" width="90">

    <h2 class="modal_join_head"><?= Yii::t('app', 'Получить купон на 50 AED'); ?></h2>

    <div>
        <?= Yii::t('app', 'Благодарим Вас за проявленный интерес. Заполните форму или'); ?>
        <a href="tel:+<?=Yii::$app->params['adminPhone']?>" class="form_join_call"><?= Yii::t('app', 'позвоните нам'); ?></a>
    </div>
    <div class="form_join_wrap w-form">
        <?php $form = ActiveForm::begin([
            'action' => $actionUrl,
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
        <?= $form->field($model, 'promocode')->textInput([
            'class' => 'callback form_join_field w-input',
            'placeholder' => Yii::t('app', 'Промокод'),
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
        

        <?= $form->field($model,'course')->hiddenInput(['value'=>$course])->label(false); ?>
        
        <?= $form->field($model,'message')->hiddenInput(['value'=>'Coupon 50 aed'])->label(false); ?>

        <?= $form->field($model, 'reCaptcha')->widget(
            ReCaptchaInvisible::className(),
            [
                'siteKey' => Yii::$app->params['reCaptcha']['siteKey'],
                'size' => ReCaptcha::SIZE_INVISIBLE,
            ]
        )->label(false) ?>

        <?= Html::submitButton(Yii::t('app', 'Получить купон'), ['class' => 'button joinform sendrequest w-button','onclick'=>'ga(\'send\', \'event\', \'form\', \'get_voucher\', \'get_voucher_sent\');return true;']) ?>
        <?php ActiveForm::end(); ?>

    </div>

    <div class="close_form" data-ix="close-form-join"><span class="close_icon">M</span> close form</div>
</div>


<!--  форма ваучера переехала в виджет
  <div class="modal_join modal_voucher"><img src="/images/page/voucher.svg" width="90">
    <h1 class="modal_join_head">Get 50 AED</h1>
    <div>We are happy to see you want to join us. Enter the form below or just</div>
    <div class="form_join_wrap w-form">
      <form data-name="Email Form" id="email-form" name="email-form">
        <input class="form_join_field voucher w-input" data-name="Name 5" id="name-5" maxlength="256" name="name-5" placeholder="Enter your name" type="text">
        <input class="form_join_field voucher w-input" data-name="Phone 7" id="Phone-7" maxlength="256" name="Phone-7" placeholder="Enter your phone" required="required" type="text">
        <input class="form_join_field voucher w-input" data-name="Message 4" id="Message-4" maxlength="256" name="Message-4" placeholder="Enter your e-mail" type="text">
        <input class="button joinform w-button" data-wait="Please wait..." type="submit" value="Get voucher">
      </form>
      <div class="callback_form modal_join_success w-form-done">
        <div>Thank you for submitting your request. Your personal academic coordinator will contact you within 24 hours</div>
      </div>
      <div class="modal_join_error w-form-fail">
        <div>Oops! Something went wrong while submitting the form</div>
      </div>
    </div>
    <div class="close_form" data-ix="close-form-join"><span class="close_icon">M</span> close form</div>
  </div>
  -->