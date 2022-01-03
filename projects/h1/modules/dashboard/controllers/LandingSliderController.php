<?php

namespace app\modules\dashboard\controllers;

use Yii;
use app\models\LandingSlider;
use app\models\LandingSliderSearch;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * LandingSliderController implements the CRUD actions for LandingSlider model.
 */
class LandingSliderController extends Controller
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
     * Lists all LandingSlider models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LandingSliderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LandingSlider model.
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
     * Creates a new LandingSlider model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LandingSlider();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->uploadImage($model, "slider/");
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing LandingSlider model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->uploadImage($model, "slider/");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LandingSlider model.
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
     * Finds the LandingSlider model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LandingSlider the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LandingSlider::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    protected function createDirectory($path) {
        if (!file_exists($path)) {
            mkdir($path, 0775, true);
        }
    }
    protected function uploadImage($model, $imagePath)
    {
        $file = UploadedFile::getInstance($model, 'image');
        if($model->del_img)
        {
            if(file_exists(Yii::getAlias('@webroot'.$model->getImageUrl())))
            {
                unlink(Yii::getAlias('@webroot'.$model->getImageUrl()));
                $model->img = '';
                $model->save();
            }
        }
        if ($file && $file->tempName) {
            $fileName = $file->baseName . '.' . $file->extension;

            $this->createDirectory($imagePath);
            $file->saveAs($imagePath . $fileName);

            $this->createDirectory($imagePath . "thumbs/");
            Image::thumbnail($imagePath . $fileName, 180, 115)->save($imagePath . "thumbs/" . $fileName, ['quality' => 80]);

            $model->img = $fileName;
            $model->save();
        }
    }
}
