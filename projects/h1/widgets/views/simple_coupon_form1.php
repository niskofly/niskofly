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
 <div class="discount-form-wrap w-form" >

        <?php $form = ActiveForm::begin([
            'action' => $actionUrl,
            'options'=>['class'=>'discount-form'],
            'fieldConfig' => ['options' => ['style'=>'margin-bottom: 2px;margin-right:35px;'],'errorOptions'=>['class'=>'help-block','style'=>'margin:0px;'] ],
        ]); ?>

        <?= $form->field($model, 'name')->textInput([
	        'class' => 'discount-form-field w-input',
            'placeholder' => Yii::t('app', 'Введите имя')
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


        
        <?= $form->field($model, 'email')->textInput([
            'class' => 'discount-form-field w-input',
            'placeholder' => Yii::t('app', 'Введите e-mail'),
        ])->label(false); ?>

        <?= $form->field($model, 'phone')->textInput([
            'class' => 'discount-form-field w-input',
            'placeholder' => Yii::t('app', 'Введите телефон'),
        ])->label(false); ?>
        
        <?= $form->field($model,'message')->hiddenInput(['value'=>'Coupon 50 aed'])->label(false); ?>
        <?= $form->field($model,'course')->hiddenInput(['value'=>$course])->label(false); ?>

        <?= $form->field($model, 'reCaptcha')->widget(
            ReCaptchaInvisible::className(),
            [
                'siteKey' => Yii::$app->params['reCaptcha']['siteKey'],
                'size' => ReCaptcha::SIZE_INVISIBLE,
            ]
        )->label(false) ?>

<!--         <?= Html::submitButton(Yii::t('app', 'Получить купон'), ['class' => 'button discountform w-button']) ?> -->
         <input class="button discountform w-button" data-wait="Please wait..." type="submit" value="<?=Yii::t('app', 'Получить купон') ?>" onclick="ga('send', 'event', 'form', 'get_voucher', 'get_voucher_sent');return true;">
        
        <?php ActiveForm::end(); ?>
</div>


<!--  форма ваучера переехала в виджет
        <div class="discount-form-wrap w-form">
          <form class="discount-form" data-name="Email Form 2" id="email-form-2" name="email-form-2">
            <input class="discount-form-field w-input" data-name="Name 3" id="name-3" maxlength="256" name="name" placeholder="Enter your name" type="text">
            <input class="discount-form-field w-input" data-name="Email" id="Mail" maxlength="256" name="Email" placeholder="Enter your email address" type="text">
            <input class="discount-form-field w-input" data-name="Phone" id="Phone-5" maxlength="256" name="Phone" placeholder="Enter your phone" required="required" type="text">
            <input class="button discountform w-button" data-wait="Please wait..." type="submit" value="Get 50 AED coupon">
          </form>
          <div class="success-message w-form-done">
            <div class="text-block">Thank you! We've sent you a voucher. Please check your e-mail</div>
          </div>
          <div class="error-message w-form-fail">
            <div class="text-block-2">Oops! Something went wrong while submitting the form :(</div>
          </div>
        </div>

  -->