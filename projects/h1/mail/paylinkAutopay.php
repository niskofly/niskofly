<?php
use yii\helpers\Html;
use yii\helpers\Url;

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
            'return_url'          => Url::toRoute(['orders/response'],true),
            'order_description'   =>$model->course,
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


/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>






    <table class="container" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFF" width="100%" style="font-family:Helvetica, sans-serif; font-size:14px; color:#333;">

        <tr>

            <td>

                <table class="container" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFF" width="100%" style="font-family:Helvetica, sans-serif; font-size:14px; color:#333; margin:0 auto; max-width: 550px;">

                    <tr>

                        <td align="center" class="logocell" style="padding:0">

                            <img src="https://cdn.laimoon.com/content_1438780028-headway.jpg" style="display:block;">

                        </td>

                    </tr>

                    <tr>

                        <td align="center">

                            <span style="display:block; font-size:14px; padding-top:10px;">Hello <?= $model->firstname?>,</span>

                        </td>

                    </tr>

                    <tr>

                        <td align="center">

                            <span style="display:block; font-size:13px; padding-top:10px;"> The below payment link has been generated for you.

                                                                </span>

                        </td>

                    </tr>

                    <tr>

                        <td><br/>

                            <table class="container" cellspacing="0" cellpadding="0" border="0" width="100%" bgcolor="#ffffff" style="background-color:#ffffff; padding:15px; border:1px solid #dddddd;">

                                <tr>

                                    <td align="center">

                                        <strong style="display:block; font-size:18px; padding-top:10px;">Monthly auto payment request</strong>

                                    </td>

                                </tr>

                                <tr>

                                    <td>

                                        <table cellspacing="0" cellpadding="0" border="0" style="padding:20px 0 0 0">

                                            <tr>

                                                <td style="padding:10px 0; white-space:nowrap;" valign="top">Course title: </td>

                                                <td style="padding:10px 10px;" valign="top"><strong><?= $model->course?></strong></span></td>

                                            </tr>

                                            <tr>

                                                <td style="padding:10px 0;" valign="top">Amount: </td>

                                                <td style="padding:10px 10px;" valign="top"><strong><?= $model->price ?> AED</td>

                                            </tr>

                                                                           
                 <tr>

                                                    <td style="padding:10px 0;" valign="top">Message: </td>

                                                    <td style="padding:10px 10px;" valign="top">
                                                    <?= $model->details ?>
                                                </td>

                                                </tr>

                                                                           
         </table>

                                    </td>

                                <tr>

                                <tr>

                                  <td align="center" colspan=3>

                                    <br/><br/><br/>
<!-- <form action="<?= $gatewayUrl ?>" method='post' name='frm'> -->
<?php   
/*
    foreach ($postData as $a => $b) 
    {
        echo "\t<input type='hidden' name='".htmlentities($a)."' value='".htmlentities($b)."'>\n";
    }
*/
?>
<!--
<input type="submit" value="Pay now" style="text-decoration:none; background-color:#3199DE; border-radius: 4px; color: #fff; display: inline-block; font-family: Tahoma,Geneva,sans-serif; font-size: 14px; font-weight: normal; padding: 10px 30px;">
</form>
-->

                                                                        <a href="<?= Url::toRoute(['/order/pay','url'=>$model->url],true) ?>" style="text-decoration:none; background-color:#3199DE; border-radius: 4px; color: #fff; display: inline-block; font-family: Tahoma,Geneva,sans-serif; font-size: 14px; font-weight: normal; padding: 10px 30px;">Pay now</a>

                                    <br/><br/><br/>

                                  </td>

                                </tr>

                            </table><br/>

                        </td>

                    </tr>

                    <tr>
                        <td align="center">
                            <p style="font-size:12px">
                                Should you wish to cancel this payment option, please, contact us on the number below.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">

                            <p style="font-size:12px">Email us <a href="mailto:info@headin.pro, courses@headin.pro" style="color:#333333; font-size:12px font-weight:bold; text-decoration:none;"><strong>info@headin.pro, courses@headin.pro</strong></a>
                                                                - Call us <strong><a style="color:#333333; font-size:12px font-weight:bold; text-decoration:none;" href="tel:+971 529444577">+971 529444577</a></strong>

                                                            </p>


                        </td>

                    </tr>

                    <tr>

                        <td align="center">

                            <br/>

                        </td>

                    </tr>

                </table>

            </td>

        </tr>

    </table>


	    
