<?php

namespace app\modules\dashboard\controllers;

use app\filters\AccessRuleUser;
use Yii;
use app\models\DynamicPrice;
use app\models\DynamicPriceSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;


/**
 * DynamicpriceController implements the CRUD actions for DynamicPrice model.
 */
class DynamicpriceController extends Controller
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
     * Lists all DynamicPrice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DynamicPriceSearch();
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
			$model=DynamicPrice::copySelectedRow($selection);
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
     * Displays a single DynamicPrice model.
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
     * Creates a new DynamicPrice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DynamicPrice();

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
     * Updates an existing DynamicPrice model.
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
     * Deletes an existing DynamicPrice model.
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
     * Finds the DynamicPrice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DynamicPrice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DynamicPrice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
