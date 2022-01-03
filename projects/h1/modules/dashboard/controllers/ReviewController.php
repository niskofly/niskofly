<?php

namespace app\modules\dashboard\controllers;

use app\filters\AccessRuleUser;
use app\models\Page;
use app\models\PageReviews;
use Yii;
use app\models\Review;
use app\models\ReviewSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class ReviewController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
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
     * Lists all Review models.
     * @return mixed
     */
    public function actionIndex()
    {
	    $searchModel = new ReviewSearch();
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
		$model=Review::copySelectedRow($selection);
	 }
	 	$url = Url::previous();
	 	if ($url)
	 	{
            	return $this->redirect($url);
     	}
	 	else
	 	{	   
	    $searchModel = new ReviewSearch();
	    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
	        'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        }
    }



    /**
     * Displays a single Review model.
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
     * Creates a new Review model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Review();

        $pages = Page::getAllPages();


        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            if ($model->save()) {
                if (PageReviews::setPageReviews($model->pages, $model->id)) {
                    $transaction->commit();
                    return $this->redirect(['index']);
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
            'pages' => $pages
        ]);
    }

    /**
     * Updates an existing Review model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        $pages = Page::getAllPages();

        $model->pages = PageReviews::getAllPageReviews($id);


        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            if ($model->save()){
                if(PageReviews::setPageReviews($model->pages, $model->id)){
                    $transaction->commit();
                    return $this->redirect(['index']);
                }
            }

            $transaction->rollBack();

        }
        return $this->render('update', [
            'model' => $model,
            'pages' => $pages
        ]);
    }

    /**
     * Deletes an existing Review model.
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
     * Finds the Review model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Review the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Review::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested review does not exist.');
        }
    }
}
