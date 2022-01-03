<?php
namespace app\commands;

use app\models\Orders;
use DateTime;
use PayfortIntegration;
use PDO;
use yii\console\Controller;
use yii;

class Synchronization extends Controller
{
    public function actionIndex(){
        $current_deals = include Yii::getAlias('@app').'/amo-api/synchronization_orders.php';
        foreach ($current_deals as $order){
            //die(var_dump($order));
            $timestamp = $order['order']['created_at'];
            $date = Yii::$app->formatter->asDatetime($timestamp,'php:Y-m-d H:i:s');
            //die(var_dump($date));
            //$date = (new \DateTime( $date, new \DateTimeZone('Asia/Dubai')))->format('Y-m-d H:i:s');
            $isset_order = Orders::find()->where(['date' => $date])->one();


            if ( $isset_order == NULL) {

                $model = new Orders();

                $model->user_id = 5;
                $model->firstname = isset($order['order']['first_name']) ? $order['order']['first_name'] : 'unknown';
                $model->lastname = isset($order['order']['last_name']) ? $order['order']['last_name'] : 'unknown';
                $model->course = isset($order['order']['course']) ? $order['order']['course'] : 'unknown';
                $model->email = isset($order['order']['email']) ? $order['order']['email'] : 'unknown';
                $model->phone = isset($order['order']['phone']) ? $order['order']['phone'] : 'unknown';
                $model->price = isset($order['order']['price']) ? $order['order']['price'] : 'unknown';
                $model->details = isset($order['order']['message']) ? $order['order']['message'] : 'unknown';
                $model->date = $date;
                $model->status = 'Новый заказ';
                $model->save();
                $model->payLink();
            }
        }
        return 0;
    }

}
?>