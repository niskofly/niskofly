<?php

namespace app\modules\dashboard\controllers;

use app\filters\AccessRuleUser;
use Yii;
use app\models\Sched;
use app\models\SchedSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;


/**
 * SchedController implements the CRUD actions for Sched model.
 */
class SchedController extends Controller
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
     * Lists all Sched models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SchedSearch();
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
			$model=Sched::copySelectedRow($selection);
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
     * Displays a single Sched model.
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
     * Creates a new Sched model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sched();

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
     * Updates an existing Sched model.
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
     * Deletes an existing Sched model.
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
     * Finds the Sched model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sched the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sched::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
