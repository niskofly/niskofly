<?php

namespace app\modules\dashboard\controllers;

use app\models\Page;
use app\models\PageReviews;
use Yii;
use app\models\PageHolyhope;
use app\models\PageHolyhopeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PageHolyhopeController implements the CRUD actions for PageHolyhope model.
 */
class PageHolyhopeController extends Controller
{
    /**
     * {@inheritdoc}
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
        ];
    }

    /**
     * Lists all PageHolyhope models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PageHolyhopeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PageHolyhope model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PageHolyhope model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PageHolyhope();

        if ($model->load(Yii::$app->request->post())){
            $HolyhopeList = $model->getHolyhopeList();
            foreach ($model->page_ids as $page_id){
                foreach ($model->holyhope_ids as $holyhope_id){
                    $item = new PageHolyhope();
                    $item->page_id = $page_id;
                    $item->holyhope_id = $holyhope_id;
                    $item->holyhope_name = $HolyhopeList[$holyhope_id];
                    $item->save();
                }
            }
            $searchModel = new PageHolyhopeSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PageHolyhope model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->page_ids = PageHolyhope::getPagesByHolyhope($model->holyhope_id);
        $model->holyhope_ids = PageHolyhope::getHolyhopeByPage($model->page_id);
        $page_ids_old = implode($model->page_ids, ',');


        if ($model->load(Yii::$app->request->post())){
            $model->deleteAll('page_id IN ('.$page_ids_old.')');
            $HolyhopeList = $model->getHolyhopeList();
            foreach ($model->page_ids as $page_id){
                foreach ($model->holyhope_ids as $holyhope_id){
                    $item = new PageHolyhope();
                    $item->page_id = $page_id;
                    $item->holyhope_id = $holyhope_id;
                    $item->holyhope_name = $HolyhopeList[$holyhope_id];
                    $item->save();
                }
            }
            $searchModel = new PageHolyhopeSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PageHolyhope model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PageHolyhope model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PageHolyhope the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PageHolyhope::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
