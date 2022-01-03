<?php

namespace app\modules\dashboard\controllers;

use app\filters\AccessRuleUser;
use Yii;
use app\models\Autopay;
use app\models\AutopaySearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use yii\bootstrap\ActiveForm;
use yii\base\Model;

/**
 * AutopayController implements the CRUD actions for Autopay model.
 */
class AutopayController extends Controller
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

    /**
     * Lists all Autopay models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AutopaySearch();
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
			$model=Autopay::copySelectedRow($selection);
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
     * Displays a single Autopay model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionValid()
    {
        $model = new Autopay();
        if ($model->load(Yii::$app->request->post())) 
        {
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = ActiveForm::validate($model);        
            
            $autopayDetails = Yii::$app->request->post('AutopayDetails');
            
            foreach ($autopayDetails as $item) {
                $modelX=new \app\models\AutopayDetails();
                $modelX->attributes = $item;
/*
                print_r($item);
                die();
*/
                $autopayDetailsModel []= $modelX;
            }
               $itemValidate = ActiveForm::validateMultiple($autopayDetailsModel);
               $result = array_merge($result, $itemValidate);

            return $result;
        }
    }

    /**
     * Creates a new Autopay model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Autopay();
        $clientDetailModel = new \app\models\AutopayDetails();

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
                'clientDetailModel' => $clientDetailModel,
            ]);
        }
    }

    /**
     * Updates an existing Autopay model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelAutopayDetails = \app\models\AutopayDetails::find()->andWhere(['autopay_id'=>$model->id])->all();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) 
	    {
/*
			$url = Url::previous();
			if ($url)
			{
            	return $this->redirect($url);
            }
            else
*/
            {
	          return $this->redirect(['index', 'id' => $model->id]);  
            }
        } else {
//	        Url::remember(Yii::$app->request->referrer);
            return $this->render('update', [
                'model' => $model,
                'clientDetailModel' => $modelAutopayDetails,
            ]);
        }
    }


    public function actionDeleteDetails($id)
    {
        if ((int)$id)
        {
            if ($model = \app\models\AutopayDetails::findOne($id))
            {
                $autopay_id = $model->autopay_id;
                $model->delete();
                return $this->redirect(['autopay/update','id'=>$autopay_id]);
            }
            
        }
        return $this->redirect(['autopay/index']);
    }

    
    public function actionAddDetails($autopay_id)
    {
        if ((int)$autopay_id)
        {
            $model = new \app\models\AutopayDetails();
            $model->autopay_id = $autopay_id;
            $model->scenario = 'add';
            $model->save();        
            return $this->redirect(['autopay/update','id'=>$autopay_id]);
        }
        return $this->redirect(['autopay/index']);
    }

    /**
     * Deletes an existing Autopay model.
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
     * Finds the Autopay model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Autopay the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Autopay::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
        $url = Url::previous();


            return $this->redirect($url);


    }
}
