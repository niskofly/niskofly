<?php

/**
 * Created by PhpStorm.
 * User: egorkozemin
 * Date: 31.01.17
 * Time: 13:07
 */
namespace app\controllers\user;

use dektrium\user\controllers\RegistrationController as BaseAdminController;
use Yii;
use app\models\RegistrationForm;
use yii\helpers\Url;

class RegistrationController extends BaseAdminController
{

    /**
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionRegister()
    {
        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException;
        }

        $model = \Yii::createObject(RegistrationForm::className());

        $this->performAjaxValidation($model);
        
//        die();

        if ($model->load(\Yii::$app->request->post()) && $model->register()) {
            return $this->goBack();
        }

        return $this->render('register', [
            'model' => $model,
            'module' => $this->module,
        ]);
    }

    /**
     * @param int $id
     * @param string $code
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionConfirm($id, $code)
    {

        $user = $this->finder->findUserById($id);

        if ($user === null || $this->module->enableConfirmation == false) {
            throw new NotFoundHttpException;
        }

        $user->attemptConfirmation($code);

        if ($this->module->enableFlashMessages && !Yii::$app->user->isGuest) {
            //Пользователь не является гостем.. делаем редирект на тест
            /**
             * Тест пока один дальнейшая логика не ясна
             */
            $this->redirect(Url::toRoute(['/tests/1/1']), 302);
        }

        return $this->render('/message', [
            'title' => \Yii::t('user', 'Account confirmation'),
            'module' => $this->module,
        ]);
    }

}