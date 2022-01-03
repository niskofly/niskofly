<?php

namespace app\controllers;

use app\models\TestLevel;
use app\models\User;
use Yii;
use yii\helpers\Url;
use yii\web\Cookie;
use yii\web\Controller;
use app\models\Test;
use app\models\TestQuestion;
use app\models\TestAnswer;
use app\models\TestLogic;
use app\models\TestResult;
use app\filters\AccessRuleUser;
use yii\filters\AccessControl;


class TestsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRuleUser::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $tests = Test::find()->all();
        return $this->render('index', [
            'tests' => $tests,
        ]);
    }

    public function actionView($id)
    {
        $model = Test::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException;
        }

        $path[] = $model->name;
        setcookie('test_score', 0, 0, Url::toRoute(['tests/view', 'id' => $id]));

        return $this->render('view', [
            'test' => $model,
            'path' => $path
        ]);
    }

    public function actionQuestion($id, $number)
    {
        $test = Test::findOne($id);
        if ($test === null) {
            throw new NotFoundHttpException;
        }

        $path[] = $test->name;

        if (Yii::$app->request->post()) {

            //Если cookie потерян
            if (empty($_COOKIE['test_score'])) {
                setcookie('test_score', 0, 0, Url::toRoute(['tests/view', 'id' => $id]));
            }

            //Подсчет набранных баллов
            $answer = TestAnswer::findOne(Yii::$app->request->post('answer'));
            $points = (!empty($answer->points)) ? $answer->points : 0;

            setcookie(
                'test_score',
                $_COOKIE['test_score'] + $points,
                0,
                Url::toRoute(['tests/view', 'id' => $id])
            );

            if ($number >= $test->getQuestionCount()) {
                return $this->redirect(Url::toRoute(['tests/result', 'id' => $id]), 302);
            } else {

                if ($answer) {
                    return $this->redirect(Url::toRoute(['tests/question', 'id' => $id, 'number' => $number + 1]), 302);
                } else {
                    Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Выберите один из предложенных ответов'));
                }
            }
        }

        $question = TestQuestion::find()->where('test_id=:id', [':id' => $id])->offset($number - 1)->limit(1)->one();
        if ($question === null) {
            throw new NotFoundHttpException;
        }

        return $this->render('question', [
            'test' => $test,
            'question' => $question,
            'number' => $number,
            'path' => $path
        ]);

    }

    public function actionResult($id)
    {
        $test = Test::findOne($id);
        if ($test === null) {
            throw new NotFoundHttpException;
        }

        $path[] = $test->name;

        $points = $_COOKIE['test_score'];
        if (!$points) {
            $points = 0;
        }

        if ($points == 0) {

            $myLevel = TestLevel::find()
                ->with('levelName')
                ->where('test_id =:id', ['id' => $id])
                ->orderBy('points_minimum')
                ->one();
        } else {
            $myLevel = TestLevel::find()
                ->with('levelName')
                ->andWhere('points_minimum <= :points', [':points' => $points])
                ->andWhere('points_maximum >= :points', [':points' => $points])
                ->andWhere('test_id =:id', ['id' => $id])
                ->limit(1)
                ->one();
        }


        //Текст уведомления
        $resultMessage = $this->prepareResultMessage($test->logic->getResult(),
            [Yii::$app->user->identity->username, $myLevel->levelName->name]);


        //Результаты тестирования
        $resultModel = new TestResult;
        $resultModel->test_id = $id;
        $resultModel->level_name_id = $myLevel->levelName->id;
        $resultModel->points = $points;
        $resultModel->name = $test->name;
        $resultModel->result = $resultMessage;
        $resultModel->user_id = Yii::$app->user->identity->id;
        $resultModel->save();


        //Уведомление на почту тестируемого
        Yii::$app->mailer->compose()
            ->setTo(Yii::$app->user->identity->email)
            ->setFrom([Yii::$app->params['adminEmail'] => 'Headway Institute'])
            ->setSubject("Headway Institute: Your test result")
            ->setHtmlBody($resultMessage)
            ->send();

        //Уведомление на почту администратору
        $message = $this->renderPartial('message_after_test', [
            'level' => $myLevel->levelName->name,
            'user' => User::findOne(['id' => Yii::$app->user->id]),
            //Begin roistat
            'roistatID' => array_key_exists('roistat_visit', $_COOKIE) ? $_COOKIE['roistat_visit'] : 'no_cookie'
            //End roistat
        ]);

        Yii::$app->mailer->compose()
            ->setTo('office@headin.pro')
            ->setFrom([Yii::$app->params['adminEmail'] => 'Headway Institute'])
            ->setSubject("Headway Institute: test result")
            ->setHtmlBody($message)
            ->send();


        return $this->render('result', [
            'test' => $test,
            'path' => $path,
            'result' => $resultMessage,
        ]);
    }


    public function actionMyresults()
    {
        $results = TestResult::find()->where(['user_id' => Yii::$app->user->identity->id])->orderBy('date desc')->all();

        return $this->render('myresults', [
            'results' => $results
        ]);
    }

    /**
     * Замена шаблона
     *
     * %Name% - имя пользователя
     * %Level% - уровень по результатам тестирования
     *
     * @param $message
     * @param $paramReplace
     *
     * @return mixed
     */
    public function prepareResultMessage($message, $paramReplace)
    {
        $pattern = ['%Name%', '%Level%'];
        return str_replace($pattern, $paramReplace, $message);

    }
}

?>