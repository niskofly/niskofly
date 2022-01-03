<?php

/* @var $this yii\web\View */
use app\models\Language;
use yii\helpers\Html;
use yii\helpers\Url;

$homeUrl = "/";
$lang = Language::getCurrent();
if(isset($lang->alias)){
    $homeUrl .= $lang->alias;
}
Yii::$app->homeUrl = $homeUrl;


$model->course =  str_replace("(", "",$model->course);
$model->course =  str_replace(")", "",$model->course);

$this->title = Yii::t('app', 'Заказ №')." ".$model->id;

$encFile =Yii::getAlias('@app'). '/extensions/payfort/PayfortIntegration.php';
require_once($encFile);    

$objFort = new PayfortIntegration();
$objFort->amount=$model->price;
$objFort->currency='AED';
$objFort->itemName=$model->course;
$objFort->customerEmail=$model->email;
        $postData = array(
            'amount'              => $objFort->convertFortAmount($objFort->amount, $objFort->currency),
            'currency'            => strtoupper($objFort->currency),
            'merchant_identifier' => $objFort->merchantIdentifier,
            'access_code'         => $objFort->accessCode,
            'merchant_reference'  => $model->id,
            'customer_email'      => $objFort->customerEmail,
            'command'             => $objFort->command,
            'language'            => $objFort->language,
            'return_url'          => Url::toRoute(['order/response'],true),
            'order_description'   => $model->course,
        );
        $postData['signature'] = $objFort->calculateSignature($postData, 'request');

//$signature = $objFort->calculateSignature($postData, 'request');
//$amount =  $objFort->convertFortAmount($objFort->amount, $objFort->currency);
        if ($objFort->sandboxMode) {
            $gatewayUrl = $objFort->gatewaySandboxHost . 'FortAPI/paymentPage';
        }
        else {
            $gatewayUrl = $objFort->gatewayHost . 'FortAPI/paymentPage';
        }



?>
<div class="container">
    <h1><?= $this->title ?></h1>
    <br>
    <table class="table">
        <tr>
            <td><?= Yii::t('app', 'First name') ?></td>
            <td><?= $model->firstname ?></td>
        </tr>
        <tr>
            <td><?= Yii::t('app', 'Last name') ?></td>
            <td><?= $model->lastname ?></td>
        </tr>
        <tr>
            <td><?= Yii::t('app', 'Ваш курс') ?></td>
            <td><?= $model->course ?></td>
        </tr>
        <tr>
            <td><?= Yii::t('app', 'Детали курса') ?></td>
            <td><?= $model->details ?></td>
        </tr>
        <tr>
            <td><?= Yii::t('app', 'Стоимость') ?></td>
            <td><?= $model->price ?> AED</td>
        </tr>
        <tfoot>
<?php if($model->paid): ?>
        <tr>
            <td colspan="2" class="success">
                <?= Yii::t('app', 'Заказ оплачен') ?>
            </td>
        </tr>
<?php else: ?>
        <tr>
            <td colspan="2" class="text-right">

<form action="<?= $gatewayUrl ?>" method='post' name='frm'>
<?php   
    foreach ($postData as $a => $b) 
    {
        echo "\t<input type='hidden' name='".htmlentities($a)."' value='".htmlentities($b)."'>\n";
    }
?>
<div>

<input type="checkbox" id="i_hereby" onclick="checkFluency()">
<label for="i_hereby">

        <?= Yii::t('app', 'I hereby confirm that I have read and accept the Institute´s terms and conditions.') ?>

</label>


<script>
    function checkFluency(){
        var checkbox=document.getElementById('i_hereby');
        if(checkbox.checked === true)
        {
            document.getElementById('i_hereby_send').disabled = false;
        }else{
            document.getElementById('i_hereby_send').disabled = true;
        }
    }
</script>
</div>
<input id="i_hereby_send" disabled type="submit" value="<?= Yii::t('app', 'Перейти к оплате') ?>" class="btn btn-primary">
</form>

                
<!--                 <a href="" class="btn btn-primary"><?= Yii::t('app', 'Перейти к оплате') ?></a> -->
                
            </td>
        </tr>
<?php endif ?>
        </tfoot>
    </table>
</div>