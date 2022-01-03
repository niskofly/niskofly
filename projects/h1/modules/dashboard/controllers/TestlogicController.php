<?php

namespace app\modules\dashboard\controllers;


use app\filters\AccessRuleUser;
use app\models\TestLevelName;
use Yii;
use app\models\TestLogic;
use app\models\TestLevel;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class TestlogicController extends Controller
{
    public $defaultAction = 'index';

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
     * Lists all TestLogic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TestLogic::find()->orderBy('ordering'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TestLogic model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TestLogic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TestLogic();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TestLogic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $levelName = TestLevelName::find()->where('language_id=:language_id',
            array(
                ':language_id' => $model->test->language_id,
            ))->andWhere(
            'test_id=:test_id',
            array(
                ':test_id' => $model->test_id,
            )
        )->all();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //Обновляем значения уровней прохождения теста
            if ($_POST['TestLevel']) {
                TestLevel::setLevelByTest($model->test->id, $_POST['TestLevel']);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'levelName' => $levelName
            ]);
        }
    }

    /**
     * Deletes an existing TestLogic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TestLogic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return TestLogic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TestLogic::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested material does not exist.');
        }
    }
}