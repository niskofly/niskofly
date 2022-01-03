<?php

namespace app\modules\dashboard\controllers;

use app\extensions\VarDumper;
use app\filters\AccessRuleUser;
use Yii;
use app\models\Orders;
use app\models\OrdersSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;


/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRuleUser::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?', '*', '@'],
                    ],
                ],
            ],
        ];
    }

    public function actionResponse()
    {
        $request = Yii::$app->request->queryParams;
        print_r($request);
        die();        
    }

    public function actionRegenerateId($id)
    {
        if ($id) {
            $transaction = Yii::$app->db->beginTransaction();
            $maxId = \app\models\Orders::findOne($id);
            $model = new \app\models\Orders();

            $model->date = $maxId->date;
            $model->details = $maxId->details;
            $model->price = $maxId->price;
            $model->paid = $maxId->paid;
            $model->level = $maxId->level;
            $model->start_date = $maxId->start_date;
            $model->schedule = $maxId->schedule;
            $model->phone = $maxId->phone;
            $model->email = $maxId->email;
            $model->course = $maxId->course;
            $model->firstname = $maxId->firstname;
            $model->lastname = $maxId->lastname;
            $model->url = $maxId->url;
            $model->id_schedule = $maxId->id_schedule;
            $model->status = $maxId->status;
            $model->date_status = $maxId->date_status;
            $model->user_id = $maxId->user_id;

            if ($model->save() && $maxId->delete()) {
                $transaction->commit();

                $amoOrder = $model->id;
                $order['updated_at'] = $model->date_status;

                include(Yii::$app->basePath . '/amo-api/update_orderAmo.php');
            } else {
                $transaction->rollback();
            }
            return $this->redirect(['orders/index']);
        }
    }    

    public function actionEmails()
    {
        $request = Yii::$app->request->queryParams;
        if ($request['url'] === '')
        {
            return $this->goHome();
        }
        $model = Orders::find()->where([ 'url' => $request['url'] ])->one();
        if ($model===null)
        {
            return $this->goHome();

        }
        $model->payLink();
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        

    }

    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
       public function actionCopy()
   {
	 	$selection=(array)Yii::$app->request->post('selection');
	 	if ($selection)
	 	{
			Url::remember(Yii::$app->request->referrer);
			$model=Orders::copySelectedRow($selection);
	 	}
	 
	 	$url = Url::previous();
	 	if ($url)
	 	{
            	return $this->redirect($url);
     	}
	 	else
	 	{
	    	$searchModel = new PageSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
			return $this->render('index', [
	        'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			]);
        }
    }
    
    

    /**
     * Displays a single Orders model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orders();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
     		$url = Url::previous();
			if ($url)
			{
            	return $this->redirect($url);
            }
            else
            {
	            return $this->redirect(['index', 'id' => $model->id]);  
            }
            
        } else {

	        Url::remember(Yii::$app->request->referrer);
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new order model for AMO CRM data.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSynchronization()
    {
        $current_deals = include Yii::$app->basePath.'/amo-api/synchronization_orders.php';

        //$url = Url::previous();

        foreach ($current_deals as $order){
            //die(var_dump($order));
            $timestamp = $order['order']['created_at'];
            $date = Yii::$app->formatter->asDatetime($timestamp,'php:Y-m-d H:i:s');
            //die(var_dump($date));
            //$date = (new \DateTime( $date, new \DateTimeZone('Asia/Dubai')))->format('Y-m-d H:i:s');
            $email = isset($order['order']['email']) ? $order['order']['email'] : 'unknown@unknown.com';

            $isset_order = Orders::find()->where(['date' => $date, 'email' => $email])->one();


            if ( $isset_order == NULL) {

                $model = new Orders();

                $model->user_id = 5;
                $model->firstname = !empty($order['order']['first_name']) ? $order['order']['first_name'] : !empty($order['order']['name']) ? $order['order']['name'] : 'unknown';
                $model->lastname = !empty($order['order']['last_name']) ? $order['order']['last_name'] : 'unknown';
                $model->course = !empty($order['order']['course']) ? $order['order']['course'] : 'unknown';
                $model->email = !empty($order['order']['email']) ? $order['order']['email'] : 'unknown@unknown.com';
                $model->phone = !empty($order['order']['phone']) ? $order['order']['phone'] : 'unknown';
                $model->price = !empty($order['order']['price']) ? $order['order']['price'] : '0';
                $model->details = !empty($order['order']['message']) ? $order['order']['message'] : 'unknown';
                $model->date = $date;
                $model->status = 'Новый заказ';
                if ($model->save()){
                    $model->payLink();
                    include Yii::$app->basePath.'/amo-api/update_order.php';
                }else{
                        var_dump($model->errors);
                        die(var_dump($order['id'], $model->firstname, $model->lastname));
                }
            }
        }
        //return $this->redirect($url);
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	        
			$url = Url::previous();
			if ($url)
			{
            	return $this->redirect($url);
            }
            else
            {
	          return $this->redirect(['index', 'id' => $model->id]);  
            }
        } else {
	        Url::remember(Yii::$app->request->referrer);
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
	    Url::remember(Yii::$app->request->referrer);
        $this->findModel($id)->delete();
		$url = Url::previous();
		if ($url)
		{
            return $this->redirect($url);
        }
        else
        {
        	return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
