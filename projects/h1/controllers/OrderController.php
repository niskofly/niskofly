<?php

namespace app\controllers;


use app\components\roistat\RoistatPayFortWidget;
use app\models\PayfortToken;
use DateTime;
use PayfortIntegration;
use PDO;
use Yii;
use yii\httpclient\Client;
use yii\web\Controller;
use app\models\Orders;
use app\models\Schedule;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use app\filters\AccessRuleUser;
use yii\filters\AccessControl;


class OrderController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionPay()
    {
        $request = Yii::$app->request->queryParams;
        if ($request['url'] === '') {
            return $this->goHome();
        }
        $model = Orders::find()->where(['url' => $request['url']])->one();
        if ($model === null) {
            return $this->goHome();

        }

        return $this->render('pay', ['model' => $model]);
        /*
                print_r($request);
                die();
        */

    }

    public function actionRecursePay()
    {
        $request = Yii::$app->request->queryParams;
        if ($request['url'] === '') {
            return $this->goHome();
        }
        $model = Orders::find()->where(['url' => $request['url']])->one();
        if ($model === null) {
            return $this->goHome();
        }

        return $this->render('recurse-pay', ['model' => $model]);
    }

    public function calculateSignature($arrData)
    {
        $shaString = '';
        ksort($arrData);
        foreach ($arrData as $k => $v) {
            $shaString .= "$k=$v";
        }

        $shaString = 'q8631sRKff' . $shaString . 'q8631sRKff';
        $signature = hash('sha256', $shaString);

        return $signature;
    }


    public function actionResponse()
    {
        $request = Yii::$app->request->post();
        $responseSignature = $request['signature'];
        unset($request['r']);
        unset($request['signature']);
        unset($request['integration_type']);
        $success = true;
        $reason = '';

        $signature = $this->calculateSignature($request, 'response');
         if($signature!==$responseSignature)
         {
             return $this->render('error',['error'=>$request]);
         }

        $response_code = $request['response_code'];
        $response_message = $request['response_message'];
        $status = $request['status'];
        if (substr($response_code, 2) != '000') {
            $success = false;
            $reason = $response_message;
            $debugMsg = $reason;
        }

        /*
                $success = true;
                $id= 89;
        */

        if(!$success) {
            $p = $request;
            $p['error_msg'] = $reason;
            return $this->render('error',['error'=>$request]);
        }
        else {
            $model = Orders::find()->where(['id' => $request['merchant_reference']])->one();
//            $model = Orders::find()->where([ 'id' => $id ])->one();
            if ($model === null) {
                return $this->goHome();
            }

            $model->paid = 1;
            $model->status = 'Оплачено';
            $model->save();

            if (isset($request['token_name'])){
                $NewToken = new PayfortToken();
                $NewToken->code = $request['token_name'];
                $NewToken->id_order = $model->id;
                $NewToken->user_id = $model->user_id;
                $NewToken->created_at = time();
                $NewToken->save();
            }



            $autopayModel = \app\models\AutopayDetails::find()->andWhere(['order_id' => $model->id])->one();
            if ($autopayModel) {
                $setTo = ['classes@headin.pro' => 'Headway Institute'];
                $subject = 'Monthly auto payment received from ' . $model->firstname . ' ' . $model->lastname;
            } else {
                $setTo = [Yii::$app->params['adminEmail'] => 'Headway Institute'];
                $subject = 'Payment received from ' . $model->firstname . ' ' . $model->lastname;
            }
            Yii::$app->mailer->compose('received', ['model' => $model])
//                ->setTo('acidmax76@icloud.com')
                ->setTo($setTo)
                ->setFrom([Yii::$app->params['adminEmail'] => 'Headway Institute'])
                ->setSubject($subject)
                ->send();


            //Begin roistat
            $customerEmail  = $request['customer_email'];
            $amount         = $request['amount'];
            RoistatPayFortWidget::widget([
                'email' => $customerEmail,
                'price' => $amount,
                'id' => $model->id
            ]);
            //end roistatdie;

            return $this->render('pay', ['model' => $model]);

        }
    }


    public function actionDeleteSubscription($id)
    {
        $payfort_token = (new \yii\db\Query())
            ->select('code')
            ->from('payfort_token')->where(['id_order' => $id])->andWhere(['user_id' => Yii::$app->user->id])
            ->createCommand()->queryOne(PDO::FETCH_COLUMN);


        //die(var_dump($payfort_token));

        $encFile = Yii::getAlias('@app') . '/extensions/payfort/PayfortIntegration.php';
        require_once($encFile);

        $objFort = new PayfortIntegration();
        $postData = array(
            'merchant_identifier' => $objFort->merchantIdentifier,
            'access_code' => $objFort->accessCode,
            'language' => $objFort->language,
            'currency' => strtoupper($objFort->currency),
            'token_status' => 'INACTIVE',
            'token_name' => $payfort_token,
            'service_command' => 'UPDATE_TOKEN',
            'merchant_reference' => Yii::$app->security->generateRandomString()

        );
        $postData['signature'] = $objFort->calculateSignature($postData, 'request');

//$signature = $objFort->calculateSignature($postData, 'request');
//$amount =  $objFort->convertFortAmount($objFort->amount, $objFort->currency);
        if ($objFort->sandboxMode) {
            $gatewayUrl = $objFort->gatewaySandboxHost . 'FortAPI/paymentApi';
        } else {
            $gatewayUrl = $objFort->gatewayHost . 'FortAPI/paymentApi';
        }
        // die(var_dump( $postData));

        $array_result = $objFort->callApi($postData, $gatewayUrl);
        //die(var_dump($array_result));
        $debugMsg = "Fort Host2Host Response Parameters \n" . print_r($array_result, 1);
        $objFort->log($debugMsg);
        if ($array_result['response_code'] == '58000') {
            $Token_update = PayfortToken::find()->where(['code' => $payfort_token])->andWhere(['user_id' => Yii::$app->user->id])->one();
            $Token_update->delete();
        }

        return Yii::$app->response->redirect(['user/settings/mycourse']);
    }

    public function actionAjaxLead()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $data = $request = Yii::$app->request->post();

            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('post')
                ->setUrl('https://forms.amocrm.ru/queue/add')
                ->setData(Yii::$app->request->post())
                ->send();

            if ($response->isOk) {
                return [
                    "data" => $response,
                    "error" => null
                ];
                // die(var_dump($response));
            } else {
                return [
                    "data" => $response,
                    "error" => "error1"
                ];
            }
        }


    }
}

/*
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRuleUser::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
*/

    /*
        public function actionCreate()
        {
            $model = new Order;
            $class_id = Yii::$app->request->get('class');

            $class = Schedule::findOne($class_id);

            $model->level = $class->level;
            $model->start_date = $class->getStartDates();
            $model->schedule = $class->getSchedule();
            $model->price = $class->price;
            $model->paid = false;
            $model->save();

            return $this->redirect(Url::toRoute(['order/view', 'id' => $model->id]), 302);

    //        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //            $model->save();
    //            return $this->render('view', ['model' => $model]);
    //        } else {
    //            return $this->render('create', ['model' => $model]);
    //        }
        }

        public function actionView($id)
        {
            $model = Order::findOne($id);
            if ($model === null) {
                throw new NotFoundHttpException;
            }

            return $this->render('view', [
                'model' => $model
            ]);
        }
    */





?>
