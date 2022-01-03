<?php

namespace app\modules\dashboard\controllers;

use app\filters\AccessRuleUser;
use app\models\CoursesGroup;
use app\models\Sched;
use Yii;
use app\models\Courses;
use app\models\CoursesSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;


/**
 * CoursesController implements the CRUD actions for Courses model.
 */
class CoursesFullController extends Controller
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
     * Lists all Courses models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CoursesSearch();
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
			$model=Courses::copySelectedRow($selection);
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
     * Displays a single Courses model.
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
     * Creates a new Courses model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelCourses = new Courses();
        if ($modelCourses->load(Yii::$app->request->post())) {
            $modelCourses->save();
        }

	        Url::remember(Yii::$app->request->referrer);
            return $this->render('create', [
                'modelCourses' =>  $modelCourses,
            ]);

    }

    /**
     * Updates an existing Courses model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $modelCourses = $this->findModel($id);



        $modelsCoursesGroup = CoursesGroup::find()->where(['id_courses' => $modelCourses->id])->all();
        $modelCoursesGroup_1 = $modelsCoursesGroup[0];
        $modelCoursesGroup_2 = $modelsCoursesGroup[1];
        $modelCoursesGroup_3 = $modelsCoursesGroup[2];

        $modelsSched_1 = Sched::find()->indexBy('id')->where(['id_courses_group' => $modelCoursesGroup_1->id])->all();
        $modelsSched_2 = Sched::find()->indexBy('id')->where(['id_courses_group' => $modelCoursesGroup_2->id])->all();
        $modelsSched_3 = Sched::find()->indexBy('id')->where(['id_courses_group' => $modelCoursesGroup_3->id])->all();

        $modelSched_1 = new Sched;
        $modelSched_1->id_courses_group = $modelCoursesGroup_1->id;



        $modelSched_2 = new Sched;
        $modelSched_2->id_courses_group = $modelCoursesGroup_2->id;


        $modelSched_3 = new Sched;
        $modelSched_3->id_courses_group = $modelCoursesGroup_3->id;
        $modelsSched_1[max(max(array_keys($modelsSched_1),array_keys($modelsSched_2),array_keys($modelsSched_3)))+1]  = $modelSched_1;
        $modelsSched_2[max(max(array_keys($modelsSched_1),array_keys($modelsSched_2),array_keys($modelsSched_3)))+1]  = $modelSched_2;
        $modelsSched_3[max(max(array_keys($modelsSched_1),array_keys($modelsSched_2),array_keys($modelsSched_3)))+1]  = $modelSched_3;





        if ($modelCoursesGroup_1 == null){
            $modelCoursesGroup_1 = new CoursesGroup;
            $modelCoursesGroup_1->id_courses = $modelCourses->id;
        }

        if ($modelCoursesGroup_2 == null){
            $modelCoursesGroup_2 = new CoursesGroup;
            $modelCoursesGroup_2->id_courses = $modelCourses->id;
        }

        if ($modelCoursesGroup_3 == null) {
            $modelCoursesGroup_3 = new CoursesGroup;
            $modelCoursesGroup_3->id_courses = $modelCourses->id;
        }



        if ($modelCourses->load(Yii::$app->request->post())) {
            $modelCourses->save();
        }


        if (isset($_REQUEST['CoursesGroup_1'])){
            if ($modelCoursesGroup_1->load(Yii::$app->request->post(),'CoursesGroup')) {
                $modelCoursesGroup_1->save();
            }
        }
        if (isset($_REQUEST['CoursesGroup_2'])){
            if ($modelCoursesGroup_2->load(Yii::$app->request->post(),'CoursesGroup')) {
                $modelCoursesGroup_2->save();
            }
        }
        if (isset($_REQUEST['CoursesGroup_3'])){
            if ($modelCoursesGroup_3->load(Yii::$app->request->post(),'CoursesGroup')) {
                $modelCoursesGroup_3->save();
            }
        }

        /*if (isset($_REQUEST['Sched'])){

            foreach($_REQUEST as $item){

                if(strpos($item, 'Sched_1_') !== false){

                    if(!empty($_REQUEST['Sched']['id'])){
                        $modelSched_1 = Sched::find()->where(['id' => $_REQUEST['Sched']['id']])->one();
                    }else{
                        $modelSched_1 = new Sched();
                        $modelSched_1->id_courses_group = $modelCoursesGroup_1->id;
                    }

                    if ($modelSched_1 !== NULL){
                       if ($modelSched_1->load(Yii::$app->request->post(),'Sched')) {
                           $modelSched_1->save();
                           $modelsSched_1 = Sched::find()->indexBy('id')->where(['id_courses_group' => $modelCoursesGroup_1->id])->all();

                           $modelSched_1 = new Sched;
                           $modelSched_1->id_courses_group = $modelCoursesGroup_1->id;
                           array_push( $modelsSched_1,$modelSched_1);
                       }
                   }
                }
                if(strpos($item, 'Sched_2_') !== false){

                    if(isset($_REQUEST['Sched']['id'])){
                        $modelSched_2 = Sched::find()->where(['id' => $_REQUEST['Sched']['id']])->one();
                    }else{
                        $modelSched_2 = new Sched();
                        $modelSched_2->id_courses_group = $modelCoursesGroup_2->id;
                    }

                    if ($modelSched_2 !== NULL){
                        if ($modelSched_2->load(Yii::$app->request->post(),'Sched')) {
                            $modelSched_2->save();
                            $modelsSched_2 = Sched::find()->indexBy('id')->where(['id_courses_group' => $modelCoursesGroup_2->id])->all();
                            $modelSched_2 = new Sched;
                            $modelSched_2->id_courses_group = $modelCoursesGroup_2->id;
                            array_push( $modelsSched_2,$modelSched_2);
                        }
                    }
                }
                if(strpos($item, 'Sched_3_') !== false){

                    if(isset($_REQUEST['Sched']['id'])){
                        $modelSched_3 = Sched::find()->where(['id' => $_REQUEST['Sched']['id']])->one();
                    }else{
                        $modelSched_3 = new Sched();
                        $modelSched_3->id_courses_group = $modelCoursesGroup_3->id;
                    }

                    if ($modelSched_3 !== NULL){
                        if ($modelSched_3->load(Yii::$app->request->post(),'Sched')) {
                            $modelSched_3->save();
                            $modelsSched_3 = Sched::find()->indexBy('id')->where(['id_courses_group' => $modelCoursesGroup_3->id])->all();
                            $modelSched_3 = new Sched;
                            $modelSched_3->id_courses_group = $modelCoursesGroup_3->id;
                            array_push( $modelsSched_3,$modelSched_3);
                        }
                    }
                }




            }
        }*/

        if (Sched::loadMultiple($modelsSched_1, Yii::$app->request->post())) {
            foreach ($modelsSched_1 as $modelSched_1) {
                if ($modelSched_1->validate()){
                    $modelSched_1->save(false);
                    $modelsSched_2 = Sched::find()->indexBy('id')->where(['id_courses_group' => $modelCoursesGroup_2->id])->all();
                    $modelSched_2 = new Sched;
                    $modelSched_2->id_courses_group = $modelCoursesGroup_2->id;
                    $modelsSched_1[max(max(array_keys($modelsSched_1),array_keys($modelsSched_2),array_keys($modelsSched_3)))+1]  = $modelSched_1;

                }
            }
        }

        if (Sched::loadMultiple($modelsSched_2, Yii::$app->request->post())) {
            foreach ($modelsSched_2 as $modelSched_2) {
                if ($modelSched_2->validate()){
                    $modelSched_2->save(false);
                    $modelsSched_2 = Sched::find()->indexBy('id')->where(['id_courses_group' => $modelCoursesGroup_2->id])->all();
                    $modelSched_2 = new Sched;
                    $modelSched_2->id_courses_group = $modelCoursesGroup_2->id;
                    $modelsSched_2[max(max(array_keys($modelsSched_1),array_keys($modelsSched_2),array_keys($modelsSched_3)))+1]  = $modelSched_2;

                }
            }
        }

        if (Sched::loadMultiple($modelsSched_3, Yii::$app->request->post())) {
            foreach ($modelsSched_3 as $modelSched_3) {
                if ($modelSched_3->validate()){
                    $modelSched_3->save(false);
                    $modelsSched_3 = Sched::find()->indexBy('id')->where(['id_courses_group' => $modelCoursesGroup_3->id])->all();
                    $modelSched_3 = new Sched;
                    $modelSched_3->id_courses_group = $modelCoursesGroup_3->id;
                    $modelsSched_3[max(max(array_keys($modelsSched_1),array_keys($modelsSched_2),array_keys($modelsSched_3)))+1]  = $modelSched_3;

                }
            }
        }



            return $this->render('update', [
                'modelCourses' => $modelCourses,
                'modelCoursesGroup_1' => $modelCoursesGroup_1,
                'modelCoursesGroup_2' => $modelCoursesGroup_2,
                'modelCoursesGroup_3' => $modelCoursesGroup_3,
                'modelsSched_1' => $modelsSched_1,
                'modelsSched_2' => $modelsSched_2,
                'modelsSched_3' => $modelsSched_3,
            ]);

    }

    /**
     * Deletes an existing Courses model.
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
     * Finds the Courses model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Courses the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Courses::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
