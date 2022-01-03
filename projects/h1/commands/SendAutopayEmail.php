<?php
namespace app\commands;

use app\models\Orders;
use DateTime;
use PayfortIntegration;
use PDO;
use yii\console\Controller;
use yii;

class SendAutopayEmail extends Controller
{
    /*public function actionIndex()
    {
        die(var_dump('asd'));
        $autopayDetails = \app\models\AutopayDetails::find()->joinWith(['autopay'])->where(['order_id'=>null])->andWhere(['pay_date'=>(new \DateTime('now', new \DateTimeZone('Asia/Dubai')))->format('Y-m-d')])->limit(2)->all();
        //$autopayDetails = \app\models\AutopayDetails::find()->joinWith(['autopay'])->where(['order_id'=>null])->limit(2)->all();
        $result = '';
        foreach ($autopayDetails as $autopayDetail) {
            $model = new \app\models\Orders();
            $model->firstname = $autopayDetail->autopay->firstname;
            $model->lastname = $autopayDetail->autopay->lastname;
            $model->course = $autopayDetail->autopay->lastname;
            $model->email = $autopayDetail->autopay->email;
            $model->phone = $autopayDetail->autopay->phone;
            $model->details = $autopayDetail->autopay->details;
            $model->price = $autopayDetail->pay_sum;
            $model->status = 'Новый заказ';
            $model->user_id = $autopayDetail->autopay->user_id;
            $transaction = Yii::$app->db->beginTransaction();
            if ($model->save()) {
                $modelAutopayD = \app\models\AutopayDetails::findOne($autopayDetail->id);
                $modelAutopayD->order_id=$model->id;
                $modelAutopayD->scenario='email';                
                if ($modelAutopayD->save())
                {
                    $transaction->commit();
                    if ($model->payLinkAutopay()) {
                            $result .= 'Отправлено письмо на: '.$model->email.' Заказ №: '.$model->id.' время отправки:'.date('H:i').PHP_EOL;
                            echo 'Отправлено письмо на: '.$model->email.' Заказ №: '.$model->id.' время отправки:'.date('H:i').PHP_EOL;
                    } else {
                            $result .= 'НЕ отправлено письмо на: '.$model->email.' Заказ №: '.$model->id.' время попытки:'.date('H:i').PHP_EOL;
                            echo 'НЕ отправлено письмо на: '.$model->email.' Заказ №: '.$model->id.' время попытки:'.date('H:i').PHP_EOL;
                    }
                }
                else
                {
                    $transaction->rollback();
                    print_r($model->getErrors());
                    $result .= 'ошибка сохранения заказа в автоплатеж'.$model->id.PHP_EOL;
                    return 1;
                }
            } else {
                    $transaction->rollback();
                    print_r($model->getErrors());
                    $result .= 'ошибка сохранения заказа по автоплатежу'.$autopayDetail->id.PHP_EOL;
                    return 1;
            }
            sleep(10);
        }
        if ($result != '') {
            $subject='Отчет по отправке писем за '.date('d.m.Y');
            $to='maxim@headin.pro';
            Yii::$app->mailer->compose()
            ->setTo($to)
            ->setFrom([Yii::$app->params['adminEmail'] => 'Headway Institute'])
            ->setSubject($subject)
            ->setTextBody($result)
            ->send();
        }
        return 0;
    }*/

    public function actionIndex(){

        $result = '';
        $payfort_tokens = (new \yii\db\Query())
            ->select(['id_order','code'])
            ->from('payfort_token')
            ->createCommand()->queryAll( PDO::FETCH_ASSOC);

        $query = (new \yii\db\Query());

        $autopay_details = (new \yii\db\Query())
            ->select('order_id')
            ->from('autopay_details')
            ->createCommand()->queryAll( PDO::FETCH_COLUMN);
        $courses = $query->select(['user.id',
            'orders.course','orders.status',
            'orders.paid','orders.start_date as date','orders.url','orders.price','orders.id as id_order', 'orders.email'])
            ->from('orders')
            ->join('LEFT JOIN', 'user', 'user.id = orders.user_id')
            ->andWhere(['in','orders.id', $autopay_details])->all();

        $orders = array_reduce($courses, function($c, $v){
            $c[ $v['course']][] = $v;
            return $c;
        }, array());

        $orders_for_pay = [];
        foreach ($orders as $key => $orders_group) {
            foreach ($orders_group as $order) {
                foreach ($payfort_tokens as $payfort_token){
                    if ($payfort_token['id_order'] == $order['id_order']) {
                        $orders_for_pay[$key]['items'] = $orders_group;
                        $orders_for_pay[$key]['token'] = $payfort_token['code'];
                    }
                }
            }
        }
        $now = new DateTime();

        $orders_for_pay_now = [];

        foreach ($orders_for_pay as $order_for_pay){
            $date_pay = null;
            foreach ($order_for_pay['items'] as $item){

                $date_pay = strtotime($item['date']);
                //todo возможно при не правельном заполнении нарушение порядка платежей
                if ($date_pay < $now->getTimestamp() and $item['paid'] == 0){
                    $item['token'] = $order_for_pay['token'];
                    $orders_for_pay_now[] =  $item;
                    break;
                }
            }
        }

        $encFile =Yii::getAlias('@app'). '/extensions/payfort/PayfortIntegration.php';
        require_once($encFile);

        foreach ($orders_for_pay_now as $item) {



            $objFort = new PayfortIntegration();
            $objFort->amount = $item['price'];
            $objFort->currency = 'AED';
            $objFort->itemName = $item['course'];
            $objFort->customerEmail = $item['email'];
            $postData = array(
                'amount' => $objFort->convertFortAmount($objFort->amount, $objFort->currency),
                'currency' => strtoupper($objFort->currency),
                'merchant_identifier' => $objFort->merchantIdentifier,
                'access_code' => $objFort->accessCode,
                'merchant_reference' => $item['id_order'],
                'customer_email' => $objFort->customerEmail,
                'command' => $objFort->command,
                'language' => $objFort->language,
                'eci' => 'RECURRING',
                'token_name' => $item['token'],
            );
            $postData['signature'] = $objFort->calculateSignature($postData, 'request');

            if ($objFort->sandboxMode) {
                $gatewayUrl = $objFort->gatewaySandboxHost . 'FortAPI/paymentApi';
            } else {
                $gatewayUrl = $objFort->gatewayHost . 'FortAPI/paymentApi';
            }





            $array_result = $objFort->callApi($postData, $gatewayUrl);

            $debugMsg = "Fort Host2Host Response Parameters \n".print_r($array_result, 1);
            $objFort->log($debugMsg);

            if ($array_result['response_code'] == '00047' || $array_result['response_code'] == '14000'){
                $order_success = Orders::find()->where(['id' => $array_result['merchant_reference']])->one();
                $order_success->paid = 1;
                $order_success->status =  'Оплачено(регулярный платеж)' ;
                $order_success->save();



                $result .= 'Регулярный платеж для '.$objFort->customerEmail.', сумма '.$objFort->amount. ' дата '.
                    $item['date'] . ' id заказа '. $array_result['merchant_reference'].PHP_EOL;

            }else{
                $result .= 'Регулярный платеж для '.$objFort->customerEmail.', сумма '.$objFort->amount. ' дата '.
                    $item['date'].' ошибка '. $array_result['response_code']
                    . ' текст ошибки '.$array_result['response_message'] . ' id заказа '. $array_result['merchant_reference'].PHP_EOL;


            }
        }

        if ($result !== ''){
            $subject='Отчет по регулярным платежам'.date('d.m.Y');
            $to='maxim@headin.pro';
            Yii::$app->mailer->compose()
                ->setTo($to)
                ->setFrom([Yii::$app->params['adminEmail'] => 'Headway Institute'])
                ->setSubject($subject)
                ->setTextBody($result)
                ->send();
        }

        return 0;
    }

    public function actionRecurringTransactions()
    {
        $autopayDetails = \app\models\AutopayDetails::find()->joinWith(['autopay'])->where(['order_id'=>null])->all();
        $result = '';
        foreach ($autopayDetails as $autopayDetail) {
            $model = new \app\models\Orders();
            $model->firstname = $autopayDetail->autopay->firstname;
            $model->lastname = $autopayDetail->autopay->lastname;
            $model->course = $autopayDetail->autopay->lastname;
            $model->email = $autopayDetail->autopay->email;
            $model->phone = $autopayDetail->autopay->phone;
            $model->details = $autopayDetail->autopay->details;
            $model->price = $autopayDetail->pay_sum;
            $model->status = 'Новый регулярный платеж';
            $model->user_id = $autopayDetail->autopay->user_id;
            $model->start_date = $autopayDetail->pay_date;


            $transaction = Yii::$app->db->beginTransaction();
            if ($model->save()) {
                $modelAutopayD = \app\models\AutopayDetails::findOne($autopayDetail->id);
                $modelAutopayD->order_id=$model->id;
                $modelAutopayD->scenario='email';
                if ($modelAutopayD->save())
                {
                    $transaction->commit();
                    $result .= 'Создан автоплатеж: '.$model->email.' Заказ №: '.$model->id.' время создания:'.date('H:i').PHP_EOL;
                }
                else
                {
                    $transaction->rollback();
                    print_r($model->getErrors());
                    $result .= 'ошибка сохранения заказа в автоплатеж'.$model->id.PHP_EOL;
                    return 1;
                }
            } else {
                $transaction->rollback();
                print_r($model->getErrors());
                $result .= 'ошибка сохранения заказа по автоплатежу'.$autopayDetail->id.PHP_EOL;
                return 1;
            }
        }
        if ($result != '') {
            $subject='Отчет по созданным автоплатежам '.date('d.m.Y');
            $to='maxim@headin.pro';
            Yii::$app->mailer->compose()
                ->setTo($to)
                ->setFrom([Yii::$app->params['adminEmail'] => 'Headway Institute'])
                ->setSubject($subject)
                ->setTextBody($result)
                ->send();

            echo $result;
        }
        return 0;
    }

}
?>